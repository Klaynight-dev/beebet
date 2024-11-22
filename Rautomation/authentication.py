import requests

class Authentication:
    def __init__(self, security_cookie: str):
        """Initialise la session avec un token existant."""
        
        self.session = requests.Session()
        self.session.cookies.update({".ROBLOSECURITY": security_cookie})
        
        self._initialize_profile()
        self._initialize_csrf_token()
        
    def _initialize_profile(self) -> bool:
        """Vérifie si le token est valide en envoyant une requête au site Roblox."""
        
        url = "https://users.roblox.com/v1/users/authenticated"
        try:
            response = self.session.get(url)
            
            if response.status_code == 200:
                self.authenticated = True
                self.profile = response.json()
            else:
                self.authenticated = False
                self.logout()
        except:
            self.authenticated = False
            self.logout()
        
        return self.authenticated
        
    def _initialize_csrf_token(self):
        """Effectue une requête pour récupérer et stocker le CSRF token dès l'initialisation."""
        
        if not self.authenticated: return
        
        url = "https://friends.roblox.com/v1/users/1/request-friendship"
        
        try:
            response = self.session.post(url)
        except:
            return False
        
        if 'x-csrf-token' in response.headers:
            self.csrf_token = response.headers['x-csrf-token']
        else:
            self.logout()
            
        return response.status_code == 200

    def logout(self) -> bool:
        """Déconnecte la session en révoquant le token."""
        
        if not self.session: return
        
        self.session.cookies.clear()
        self.session = None
        
        return True

    def get_headers(self) -> dict:
        """Renvoie les headers HTTP avec le token pour les requêtes."""
        
        return {"Requester": "Client", "X-CSRF-TOKEN": self.csrf_token}