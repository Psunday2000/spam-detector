from flask import Flask, request, jsonify
import pickle

app = Flask(__name__)

# Load the model and vectorizer
with open('spam_model.pkl', 'rb') as model_file:
    spam_model = pickle.load(model_file)
with open('vectorizer.pkl', 'rb') as vectorizer_file:
    extract_feature = pickle.load(vectorizer_file)

@app.route('/predict', methods=['POST'])
def predict():
    data = request.json
    email_content = data['email_content']
    
    # Transform the email content using the vectorizer
    email_features = extract_feature.transform([email_content])
    
    # Predict using the model
    prediction = spam_model.predict(email_features)
    
    return jsonify({'is_spam': bool(prediction[0])})

if __name__ == '__main__':
    app.run(debug=True, host='0.0.0.0', port=5000)
