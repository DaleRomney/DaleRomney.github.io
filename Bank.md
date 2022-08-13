# Tiger Banking

In this program, I used .Net 6 MVC pattern to create a simple banking app where the user could create an account, deposit money into one of three accounts: checking,
savings, or savings 2. You could also withdraw from those accounts and view a history of those accounts. Below is my code for the backend of the deposit page.
 
 ```markdown
  [HttpPost]
        [ValidateAntiForgeryToken]
        public IActionResult Deposit(AccountVM obj, int userId)
        {
            if (ModelState.IsValid)
            {
                int UserId = userId;
                Accounts account = _db.Accounts.Where(u => u.UserId == UserId && u.AccountTypeId == obj.Account.AccountTypeId).FirstOrDefault();
                account.Balance += obj.Account.Balance;

                _unitOfWork.Account.Update(account);
                _unitOfWork.Save();

                Transactions newTransaction = new Transactions()
                {
                    AccountID = account.AccountId,
                    AccountTypeId = account.AccountTypeId,
                    UserId = account.UserId,
                    TransactionType = "Deposit",
                    Balance = account.Balance,
                    Amount = obj.Account.Balance,
                    Date = DateTime.Now
                };

                _unitOfWork.Transaction.Add(newTransaction);
                _unitOfWork.Save();

                User user = _unitOfWork.Users.GetFirstOrDefault(u => u.userId == UserId);
                TempData["success"] = "Balance Updated.";
                return RedirectToAction("Bank", user);
            }

            obj.AccountTypeList = _unitOfWork.AccountType.GetAll().Select(i => new SelectListItem
            {
                Text = i.Name,
                Value = i.AccountTypeId.ToString()
            });

            return View(obj);
        }
```
Here are some sample pictures of the application

### The Home Page
![Home Page](/Porfolio/Bank_Main.jpg)

### Deposit Page
![Deposit Page](/Porfolio/Bank_Deposit.jpg)

### Withraw Page
![Withdraw Page](/Porfolio/Bank_Withdraw.jpg)

### History Page
![History Page](/Porfolio/Bank_Overview.jpg)
