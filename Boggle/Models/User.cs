using Microsoft.AspNetCore.SignalR.Client;

namespace Boggle.Models
{
    public class User
    {
        public User() 
        {
            ConnectedOn = DateTime.Now;
            ready = false;
            GuessedWords = new();
        }
    
        public User(string connectionID, string name)
        {
            ConnectionID = connectionID;
            Name = name;
            ConnectedOn = DateTime.Now;
            IsGameFinished = false;
        }

        public string? ConnectionID { get; set; }
        public string? Name { get; set; }
        public DateTime ConnectedOn { get; set; }
        public HubConnection? hub { get; set; }
        public string? password { get; set; }
        public string? GroupName { get; set; }
        public bool ready { get; set; }
        public bool IsGameFinished { get; set; }
        public List<string> GuessedWords { get; set; }
        public int? score { get; set; }
        public List<List<char>>? board;


    }
}
