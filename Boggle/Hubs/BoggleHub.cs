using Microsoft.AspNetCore.SignalR;
using Boggle.Models;

namespace Boggle.Hubs
{
    public class BoggleHub : Hub
    {
        private static Dictionary<string, Game> Games = new Dictionary<string, Game>();
        private static List<Boggle.Models.User> Users = new List<User>();
        private static Dictionary<string, int> groups = new Dictionary<string, int>();
        private static sliceofbreadContext? sliceofbreadContext;
        public const string HubURL = "/Game";

        public override async Task OnConnectedAsync()
        {
            sliceofbreadContext = new sliceofbreadContext();
            await Clients.Caller.SendAsync("GetConnectionID", this.Context.ConnectionId);
        }

        public override async Task OnDisconnectedAsync(Exception? e)
        {
            await base.OnDisconnectedAsync(e);
        }
        
        public Dictionary<string, string> GetUserInfo(string connID)
        {
            var mydict = new Dictionary<string, string>();
            var temp = Users.Where(x => x.ConnectionID == connID).First();
            mydict.Add("name", temp.Name);
            mydict.Add("Password", temp.password);
            return mydict;
        }
        
        public string FindWinner(string password)
        {
            var temp = Games[password];
            if (temp.Players[0].score > temp.Players[1].score)
            {
                return temp.Players[0].Name;
            }
            else return temp.Players[1].Name;      
        }

        
        
        public void ImReady(string name)
        {
            Users.Where(x => x.Name == name).FirstOrDefault().ready = true;
        }
        
        public void addWord(string name, string password, string word)
        {
            var temp = Users.Where(x => x.Name == name).FirstOrDefault();
            temp.GuessedWords.Add(word);
            temp.score += Games[password].AddScore(word);

        }

        
        
        public bool ready(string password, string name)
        {
            int count = 0;

            foreach (var user in Users)
            {
                if (user.password == password)
                {
                    if (user.ready == true)
                    {
                        count++;
                        
                    }
                }
            }
            bool result = count == 2;
            return count == 2;
        }
        
        public bool AddUserToGroup(string connID, string name, string password, bool joining)
        {

            if (!joining)
            {
                Game g = new Game();
                User usr = new User();
                usr.ConnectionID = connID;
                usr.ConnectedOn = DateTime.Now;
                usr.Name = name;
                usr.password = password;
                Users.Add(usr);
                groups.Add(password, 1);
                g.Players.Add(usr);
                g.GroupName = password;
                Games.Add(password, g);
                Groups.AddToGroupAsync(connID, password);
                return true;
            }
            else
            {
                if (!groups.ContainsKey(password) || groups[password] > 2)
                {
                    return false;
                }
                else
                { 
                    User usr = new User();
                    usr.ConnectionID = connID;
                    usr.ConnectedOn = DateTime.Now;
                    usr.Name = name;
                    usr.password = password;
                    Users.Add(usr);
                    Games[password].Players.Add(usr);
                    groups[password]++;
                    return true;
                }
            }
        }

        public bool IsReady(string password)
        {
            if (groups[password] == 2)
            {
                return true;
            }
            return false;
        }


        public bool FindGroup(string password)
        {
            if (groups.ContainsKey(password))
            {
                return true;
            }
            else
            {
                return false;
            }

        }

        public string GeneratePassword()
        {
            Random rand = new Random();
            string password = "";
            for(int i = 0; i < 8; i++)
            {
                int randomletter = rand.Next(65, 90);
                password += (char)randomletter;
            }
            return password;
        }


    }
}
