# Stock Investing Game

In this program, we using .Net 6 Razor Pages and Ajax to communicate between the front-end and back-end. We also used an API and a random date in the past to pull a
certain stock price from whatever company's ticker symbol you chose. In the program you can use either a textbox, slider, or pie chart to select how many shares of
the stock you would like to puchase. In the game you get $10,000.00 to spend and the game plays out for seven days. At the end of the seven days, you find out how much
money you either gained or lost.
 
 ```markdown
  public IActionResult OnPostSellStocks(int value)
        {
            try
            {
                var symbol = HttpContext.Session.GetString("ticker"); //Setting the ticker symbol to what the user has entered
                var dailyPrices = $"https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol={symbol}&outputsize=full&apikey={apiKey}&datatype=csv"
                    .GetStringFromUrl().FromCsv<List<StockData>>();
                
                var vDateIndex = HttpContext.Session.GetInt32("currentDay"); //getting date index
                int iDateIndex = vDateIndex.Value;
               
                var dayPrice = dailyPrices[iDateIndex].Close;//This gets the price
                price = dayPrice;
                HttpContext.Session.SetString("price", price.ToString());
                string sSessionPrice = HttpContext.Session.GetString("price"); //Getting session price
                string sSessionBalance = HttpContext.Session.GetString("balance"); //Getting session balance
                var vDayCounter = HttpContext.Session.GetInt32("dayCounter");
                int iDayCounter = vDayCounter.Value;
                iDayCounter++;
                var iSessionShares = HttpContext.Session.GetInt32("shares"); //Getting sessions shares
                int ownedShares = iSessionShares.Value; //Have to convert nullable-int to int
                balance = Convert.ToDecimal(sSessionBalance);
                price = Convert.ToDecimal(sSessionPrice);
                string endGame = endGameScenario();
                while (iDayCounter < 8)
                {
                    decimal totalSellingPrice = price * value;
                    decimal total = balance + totalSellingPrice;


                    //Checking if the amount of shares being sold are greater than the amount of shares owned
                    if (value > ownedShares)
                    {
                        return new JsonResult("You do not have enough shares to sell!");
                    }
                    else
                    {
                        int iSubtractedShares = ownedShares - value;


                        iDateIndex++;
                        HttpContext.Session.SetInt32("currentDay", iDateIndex);
                        HttpContext.Session.SetInt32("dayCounter", iDayCounter);
                        HttpContext.Session.SetInt32("shares", iSubtractedShares); //Setting session shares held
                        HttpContext.Session.SetString("balance", total.ToString()); //Setting session balance
                        return new JsonResult(value + " share(s) sold. <br> Current Balance: $" + total + "<br> Shares Held: " + iSubtractedShares + "<br> Current Day: " + iDayCounter + "<br> New Price:  $" + price);

                    }
                }

                return new JsonResult(endGame);//endGameScenario());
            }
            catch (Exception)
            {
                return new JsonResult("There was a problem selling these stocks!");

            }
        }
```
Here are some sample pictures of the application

### Inputing a Ticker Symbol
![Home Page](https://github.com/DaleRomney/DaleRomney.github.io/blob/main/Porfolio/Stock_Ticker_Selected.jpg)

### Buying Stocks
![Buying Stocks](https://github.com/DaleRomney/DaleRomney.github.io/blob/main/Porfolio/Stock_Purchase.jpg)

### Selling Stocks
![Selling Stocks](https://github.com/DaleRomney/DaleRomney.github.io/blob/main/Porfolio/Stock_Sale.jpg)

### Final Results
![Final Results](https://github.com/DaleRomney/DaleRomney.github.io/blob/main/Porfolio/Stock_Final.jpg)
