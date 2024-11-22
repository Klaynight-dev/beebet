from flask import Flask, request, jsonify
from Rautomation import Authentication, UserProfile
import logging

app = Flask(__name__)

# Configuration du logging
logging.basicConfig(level=logging.DEBUG, format='%(asctime)s - %(levelname)s - %(message)s')

@app.route('/generate_username', methods=['POST'])
def generate_username():
    data = request.get_json()
    if not data or 'token' not in data:
        logging.error('Token manquant ou vide dans la requête.')
        return jsonify({'success': False, 'message': 'Token manquant ou vide.'})

    token = data['token']
    auth = Authentication(token)
    
    if auth.authenticated:
        pseudo = auth.profile.get("displayName")
        logging.info(f'Nom d’utilisateur généré : {pseudo}')
        return jsonify({'success': True, 'username': pseudo})
    else:
        logging.error('Échec de l\'authentification avec le token.')
        return jsonify({'success': False, 'message': 'Échec de l\'authentification'})

@app.route('/get_robux', methods=['POST'])
def get_robux():
    data = request.get_json()
    if not data or 'token' not in data:
        logging.error('Token manquant ou vide dans la requête pour obtenir les Robux.')
        return jsonify({'success': False, 'message': 'Token manquant ou vide.'})

    token = data['token']
    auth = Authentication(token)
    
    if auth.authenticated:
        robux_balance = UserProfile.get_robux_balance(auth)
        logging.info(f'Balance de Robux récupérée : {robux_balance}')
        return jsonify({'success': True, 'robux': robux_balance})
    else:
        logging.error('Échec de l\'authentification pour récupérer les Robux.')
        return jsonify({'success': False, 'message': 'Échec de l\'authentification'})

@app.route('/get_avatar', methods=['POST'])
def get_avatar():
    data = request.get_json()
    token = data.get('token')

    auth = Authentication(token)
    if auth.authenticated:
        user_id = auth.profile.get("id")
        avatar_url = UserProfile.get_avatar_url(auth, user_id)
        logging.debug(f'Avatar url trouvé : {avatar_url}')
        if avatar_url:
            return jsonify({'success': True, 'avatar_url': avatar_url})
        else:
            return jsonify({'success': False, 'message': 'Échec de récupération de l\'avatar'})
    return jsonify({'success': False, 'message': 'Échec de l\'authentification'})

if __name__ == '__main__':
    app.run(port=5000)
