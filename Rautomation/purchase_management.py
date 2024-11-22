class PurchaseManagement:
    def get_robux(self):
        headers = self.get_headers()
        
        url = f"https://economy.roblox.com/v1/users/{self.profile["id"]}/currency"
        
        responce = self.session.get(url)
        
        return responce.json()["robux"]
    
    def purchase_gamepass(self, infos):
        headers = self.get_headers()
    
        url = f"https://economy.roblox.com/v1/purchases/products/{infos["ProductId"]}"
        
        data = {
            "expectedCurrency": 1,
            "expectedPrice": infos["PriceInRobux"],
            "expectedSellerId": infos["Creator"]["Id"]
        }
        
        responce = self.session.post(
            url,
            headers=headers,
            data=data,
        )
        
        print(responce.json())