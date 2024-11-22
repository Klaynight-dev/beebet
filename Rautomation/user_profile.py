class UserProfile:
    def set_description(self, description: str):
        headers = self.get_headers()
        
        url = "https://users.roblox.com/v1/description"
        
        responce = self.session.post(
            url,
            headers=headers,
            data={"description": description}
        )
        
        return responce.status_code == 200
    
    def get_robux_balance(self):
        headers = self.get_headers()
        
        url = "https://economy.roblox.com/v1/user/currency"
        
        response = self.session.get(
            url,
            headers=headers
        )
        
        if response.status_code == 200:
            robux_data = response.json()
            return robux_data.get("robux", 0)
        return None
    
    def get_avatar_url(self, user_id):
        headers = self.get_headers()
        
        url = f"https://thumbnails.roblox.com/v1/users/avatar-headshot?userIds={user_id}&size=150x150&format=png"
        
        response = self.session.get(
            url,
            headers=headers
        )
        
        if response.status_code == 200:
            avatar_data = response.json()
            if avatar_data.get("data"):
                return avatar_data["data"][0].get("imageUrl")
        return None
    
    def set_gender(self, type: int): # type = 1,2,3
        headers = self.get_headers()
        
        url = "https://users.roblox.com/v1/gender"
        
        responce = self.session.post(
            url,
            headers=headers,
            data={"gender": type}
        )
        
        return responce.status_code == 200
    
    def set_theme(self, theme): # theme = "Light", "Dark"
        headers = self.get_headers()
        
        url = "https://accountsettings.roblox.com/v1/themes/user"
        
        responce = self.session.patch(
            url,
            headers=headers,
            data={"themeType": theme}
        )
        
        return responce.status_code == 200
    
    """
    profile = "Rautomation"
    UserProfile.set_social(auth, {
        "promotionChannelsVisibilityPrivacy": "AllUsers",
        "facebook": f"www.facebook.com/{profile}",
        "twitter": f"@{profile}",
        "youtube": f"www.youtube.com/user/{profile}",
        "twitch": f"www.twitch.tv/{profile}/profile", 
        "guilded": f"guilded.gg/{profile}"}
    )
    """
    
    def set_social(self, datas):
        headers = self.get_headers()
        
        url = "https://accountinformation.roblox.com/v1/promotion-channels"
        
        responce = self.session.post(
            url,
            headers=headers,
            data=datas
        )
        
        return responce.status_code == 200