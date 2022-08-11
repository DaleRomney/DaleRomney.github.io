namespace Boggle.Models
{
    public class Board
    {
        public Board()
        {
            row1 = fillRow();
            row2 = fillRow();
            row3 = fillRow();
            row4 = fillRow();
            BoggleBoard = new List<List<char>>
            {
                row1,
                row2,
                row3,
                row4
            };
        }
        public List<char> row1;
        public List<char> row2;
        public List<char> row3;
        public List<char> row4;
        public List<List<char>> BoggleBoard;
        private Dictionary<char, int> Vowels = new Dictionary<char, int>
        {
            {'A', 0},
            {'E', 0},
            {'I', 0},
            {'O', 0},
            {'U', 0}
        };
        private Dictionary<char, int> Constants = new Dictionary<char, int>
        {
            {'B', 0},
            {'C', 0},
            {'D', 0},
            {'F', 0},
            {'G', 0},
            {'H', 0},
            {'J', 0},
            {'K', 0},
            {'L', 0},
            {'M', 0},
            {'N', 0},
            {'P', 0},
            {'Q', 0},
            {'R', 0},
            {'S', 0},
            {'T', 0},
            {'V', 0},
            {'W', 0},
            {'X', 0},
            {'Y', 0},
            {'Z', 0}
        };

        private List<int> randomizeOrder()
        {
            List<int> order = new List<int>();
            Random rand = new Random();
            while (order.Count < 4)
            {
                var r = rand.Next(0, 4);
                if (!order.Contains(r))
                    order.Add(r);
            }
            return order;
        }

        //still a work in progress, but it works for now.
        private List<char> fillRow()
        {
            Random rand = new Random();
            List<int> order = randomizeOrder();
            List<char> row = new List<char>();
            int counter = 0;
            char[] temp = new char[4];
            while (counter < 4)
            {
                var tempvowels = Vowels;
                var tempconstants = Constants;
                int vr = rand.Next(0, 5);
                char vowel = tempvowels.Keys.ElementAt(vr);
                int cr = rand.Next(0, 21);
                char constant = Constants.Keys.ElementAt(cr);
                if (Vowels[vowel] < 3)
                {
                    temp[order[counter++]] = vowel;
                    tempvowels[vowel]++;
                }
                if (Constants[constant] < 2 && counter < 4)
                {
                    temp[order[counter++]] = constant;
                    tempconstants[constant]++;
                }
                else
                {
                    continue;
                }
            }

            row = temp.ToList();
            return row;
        }
    }
}
