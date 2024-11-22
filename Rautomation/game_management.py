class GameManagement:
    """
        last_game_id = GameManagement.get_games(auth, 10)[0]["id"]
    """
    
    def get_games(self, size = 10):
        url = f"https://apis.roblox.com/universes/v1/search?CreatorType=User&CreatorTargetId={self.profile["id"]}&PageSize={size}&SortParam=LastUpdated"
        responce = self.session.get(url).json()
        
        return responce["data"]
    
    """
    gamepass_id = GameManagement.create_gamepass(auth, {
        "Name": "Gamepass",
        "Description": "",
        "UniverseId": last_game_id
    })
    """
    
    def create_gamepass(self, datas):
        headers = self.get_headers()
        
        url = "https://apis.roblox.com/game-passes/v1/game-passes"
        
        responce = self.session.post(
            url,
            headers=headers,
            data=datas
        )
        
        return responce.json()["gamePassId"]
    
    """
    GameManagement.set_gamepass_price(auth, gamepass_id, 0)
    """
    
    def set_gamepass_price(self, gamepass_id, price):
        headers = self.get_headers()
        
        data = {
            "IsForSale": price != 0,
            "Price": price,
        }
        
        self.session.post(
            f"https://apis.roblox.com/game-passes/v1/game-passes/{gamepass_id}/details",
            headers=headers,
            data=data
        )
        
        return gamepass_id
    
    """
    devproduct_id = GameManagement.create_devproduct(auth, {
        "Name": "Dev Product 2",
        "Description": "",
        "UniverseId": last_game_id,
        "Price": 100
    })
    """
    
    def create_devproduct(self, datas):
        headers = self.get_headers()
        
        url = f"https://apis.roblox.com/developer-products/v1/universes/{datas["UniverseId"]}/developerproducts?name={datas["Name"]}&description={datas["Description"]}&priceInRobux={datas["Price"]}"
        
        responce = self.session.post(
            url,
            headers=headers
        )
        
        return responce.json()["id"]
    
    def get_info(self, id:int):
        url = f"https://apis.roblox.com/game-passes/v1/game-passes/{id}/product-info"
        
        responce = self.session.get(url)
        
        return responce.json()