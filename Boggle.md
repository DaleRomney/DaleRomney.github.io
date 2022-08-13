# Grid Word Finder

In this program, we using Blazor Pages with SignalR and Azure to create a two player game similar to Boggle. In this application we use a Hub with groups to make groups
of two users who play against each other. We randomly populate the game board with letters and players click on the letters to form words. When they have formed a word,
they click on the last word clicked again and then we use websockets to send the word back to the server, check if it is a word, if it is, we place that word in a List
of correct words and give the user points. Whom ever has the most points at the end of the game, wins. Below is some sample code.
 
 ```markdown
  public async void btnClick(string a)
    {
        //ID is in the form: "{letter}{int}"
        Count = 0;
        char selected = a[0];
        int id = int.Parse(a.Remove(0,1));
        if (isValidSelection(id, a))
        {
            if (dict[a] is true)
            {
                if (await Task<bool>.Run(() => Models.Game.IsWord(CurrWordSelected, Context)))
                {
                    if(!usr.GuessedWords.Contains(CurrWordSelected))
                    {
                        CurrScore = Models.Game.AddScores(CurrWordSelected);
                        usr.score += CurrScore;
                        usr.hub.InvokeAsync("addWord", usr.Name, usr.password, CurrWordSelected);
                        usr.GuessedWords.Add(CurrWordSelected);
                        score += CurrScore;
                    }

                    CurrWordSelected = "";
                    foreach (var item in dict.Keys)
                    {
                        if (dict[item])
                        {
                            dict[item] = false;
                            await Task.Run(() => js.InvokeVoidAsync("getAll", item));
                        }
                    }
                }
                else
                {
                    CurrWordSelected = "";
                    resetValidPositions();
                    foreach (var item in dict.Keys)
                    {
                        if (dict[item])
                        {
                            dict[item] = false;
                            await Task.Run(() => js.InvokeVoidAsync("getAll", item));
                        }
                    }
                }
            }
            else
            {
                CurrWordSelected += selected;
                await Task.Run(() => js.InvokeVoidAsync("getAll", a));
                dict[a] = true;
                GetValidSelections(id);
            }
        }
        return;
    }
```
Here are some sample pictures of the application

### The Home Page
![Home Page](/Porfolio/Boggle_Home.jpg)

### Join Game Lobby Page
![Deposit Page](/Porfolio/Boggle_Join_Game.jpg)

### Game Page
![Withdraw Page](/Porfolio/Boggle_Game.jpg)
