from flask import Flask, request, jsonify
import pandas as pd
import numpy as np
import pmdarima as pm
from sklearn.metrics import mean_absolute_error
import warnings

# Mengabaikan peringatan yang tidak krusial agar output terminal lebih bersih
warnings.filterwarnings("ignore")

app = Flask(__name__)

def calculate_mape(y_true, y_pred):
    """Menghitung Mean Absolute Percentage Error (MAPE)"""
    y_true, y_pred = np.array(y_true), np.array(y_pred)
    # Filter nilai y_true yang nol untuk menghindari pembagian dengan nol
    non_zero_mask = y_true != 0
    if not np.any(non_zero_mask):
        return 0.0
    return np.mean(np.abs((y_true[non_zero_mask] - y_pred[non_zero_mask]) / y_true[non_zero_mask])) * 100

@app.route('/predict', methods=['POST'])
def predict():
    try:
        # 1. Menerima data dari request
        req_data = request.get_json(force=True)
        time_series_data = req_data['data']
        n_periods = int(req_data['periods'])

        # 2. Konversi data menjadi DataFrame dan siapkan time series
        df = pd.DataFrame(time_series_data)
        df['periode'] = pd.to_datetime(df['tahun'].astype(str) + '-' + df['bulan'].astype(str))
        df = df.set_index('periode')
        ts = df['jumlah_ekspor'].astype(float)

        # Cek apakah data cukup
        if len(ts) < 24:
            return jsonify({'error': 'Data historis tidak cukup (minimal 24 bulan).'}), 400

        # 3. Terapkan transformasi log untuk menstabilkan data
        # Menambahkan 1 untuk menghindari log(0)
        log_ts = np.log(ts + 1)

        # 4. Bagi data: 12 bulan terakhir untuk testing, sisanya untuk training
        train_log = log_ts[:-12]
        test_actual = ts[-12:] # Data aktual untuk perbandingan (bukan log)

        # 5. Latih model pada data training (log) untuk evaluasi
        eval_model = pm.auto_arima(
            train_log, 
            m=12,              # Frekuensi musiman (12 bulan)
            seasonal=True,     # Aktifkan SARIMA
            suppress_warnings=True,
            stepwise=True
        )
        
        # Prediksi pada periode test
        log_forecast_eval = eval_model.predict(n_periods=len(test_actual))
        # Kembalikan prediksi ke skala asli
        original_forecast_eval = np.exp(log_forecast_eval) - 1
        
        # 6. Hitung MAPE dan MAE berdasarkan hasil evaluasi
        mape = calculate_mape(test_actual.values, original_forecast_eval.values)
        mae = mean_absolute_error(test_actual.values, original_forecast_eval.values)

        # 7. Latih model final pada KESELURUHAN data (log) untuk peramalan masa depan
        final_model = pm.auto_arima(
            log_ts, # Menggunakan seluruh data log
            m=12,
            seasonal=True,
            suppress_warnings=True,
            stepwise=True
        )
        
        # Lakukan peramalan untuk n_periods ke depan
        final_log_forecast = final_model.predict(n_periods=n_periods)
        # Kembalikan peramalan ke skala asli
        final_original_forecast = np.exp(final_log_forecast) - 1
        
        # Siapkan tanggal untuk periode mendatang
        future_dates = pd.date_range(start=ts.index[-1] + pd.DateOffset(months=1), periods=n_periods, freq='MS')

        # 8. Siapkan hasil dalam format JSON yang sesuai dengan frontend Anda
        predictions_list = []
        for date, value in zip(future_dates, final_original_forecast):
            predictions_list.append({
                'periode': date.strftime('%B %Y'),
                'prediksi': value
            })

        response = {
            'predictions': predictions_list,
            'mae': mae,
            'mape': mape,
            'best_order': final_model.order,
            'best_seasonal_order': final_model.seasonal_order,
            'model_summary': str(final_model.summary())
        }

        return jsonify(response)

    except Exception as e:
        return jsonify({'error': str(e)}), 500

if __name__ == '__main__':
    app.run(port=5000, debug=True)
