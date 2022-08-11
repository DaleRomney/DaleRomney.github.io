using Microsoft.EntityFrameworkCore;
using Microsoft.EntityFrameworkCore.Internal;

namespace Boggle.Models
{
    public class Game
    {
        public Game()
        {
            Players = new();
            GameStarted = false;
        }
        public bool GameStarted { get; set; }
        public string GroupName { get; set; }
        public List<User> Players { get; set; }
        public sliceofbreadContext? db { get; set; }
        public static async Task<bool> IsWord(string word, sliceofbreadContext db)
        {
            //var test = word.ToLower();
            return await Task.Run(() => db.Words.Any(x => x.Word == word));
        }

        public int AddScore(string word)
        {
            int length = word.Length;
            
            if (length == 3)
            {
                return 1;
            }
            else if(length == 4)
            {
                return 2;
            }
            else if (length == 5)
            {
                return 4;
            }
            else if (length == 6)
            {
                return 6;
            }
            else if (length == 7)
            {
                return 8;
            }
            else if (length == 8)
            {
                return 10;
            }
            else
            {
                return 15;
            }
        }

        public static int AddScores(string word)
        {
            int length = word.Length;

            if (length == 3)
            {
                return 1;
            }
            else if (length == 4)
            {
                return 2;
            }
            else if (length == 5)
            {
                return 4;
            }
            else if (length == 6)
            {
                return 6;
            }
            else if (length == 7)
            {
                return 8;
            }
            else if (length == 8)
            {
                return 10;
            }
            else
            {
                return 15;
            }
        }

        public void StartGame(User p1, User p2)
        {
            GameStarted = true;
        }
        public void EndGame()
        {
            GameStarted = false;
            Players.Clear();
        }
    }
}

