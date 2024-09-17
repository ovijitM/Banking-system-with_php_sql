# <h1 align="center">Echo Bank Database Management System</h1>


<p align="center">
    A comprehensive database management system for Echo Bank, managing customer accounts, transactions, loans, donations, and complaints.
</p>

---

## <h2 id="table-of-contents">📑 Table of Contents</h2>

- [🏦 Database Structure](#database-structure)
- [🛠️ Functionalities](#functionalities)
- [📊 Table Structures](#table-structures)
- [📝 SQL Schema](#sql-schema)
- [📝 ER Diagram](#er-diagram)

---

## <h2 id="database-structure">🏦 Database Structure</h2>

### <h3>Tables</h3>

1. **Customer Table**: Stores all customer details, including approved and pending accounts.
2. **Account Table** : Store only Bank customer info.
3. **Loan Table**: Stores details about loan requests and approvals with unique loan account numbers.
4. **Transaction Table**: Records all transactions with unique reference IDs for each.
5. **Donation Table**: Stores details of donations made by customers.
6. **Complain Box Table**: Stores complaints submitted by customers.
7. **Vault Table**: Holds the balance of the bank's vault.
8. **Stuff Table**: bank admins are login and their info is store here.

---

## <h2 id="functionalities">🛠️ Functionalities</h2>

### <h3>Bank Side Functionalities</h3>

- **Open Account**: Approve account requests submitted by customers.
- **Transaction History**: View transaction history of any account.
- **Deposit**: Add funds to a customer account.
- **Withdraw**: Withdraw funds from a customer account.
- **Fund Transfer**: Transfer funds between accounts within the bank.
- **Loan Approval**: Review and approve or deny loan requests.
- **User Approval**: Approve or reject user account requests.
- **Loan Calculator**: Calculate loan amounts, interest, and repayment schedules.
- **Complain List**: View and manage complaints submitted by customers.

### <h3>User Side Functionalities</h3>

- **Account Open Request**: Submit a request to open an account.
- **Sign In**: Log in to the user account.
- **Send Money**: Transfer money to another account.
- **Pay Bill**: Pay bills using the account balance.
- **Loan Apply**: Apply for a loan, specifying the amount and purpose.
- **Donation**: Donate funds to specified accounts or causes.
- **Complain Box**: Submit complaints about services or issues.
- **Loan Calculator**: Calculate possible loan terms and amounts.
- **User Transaction History**: View personal transaction history.
- **Dashboard**: View account balance, recent transactions, and other account information.

---

## <h2 id="table-structures">📊 Table Structures</h2>

| Table Name        | Description                                           |
|-------------------|-------------------------------------------------------|
| **Customer**      | Stores customer details, including status and balance |
| **Account**       | Stores only approved bank customer info                | 
| **Loan**          | Manages loan requests and approvals                   |
| **Transaction**   | Records all transactions with unique reference IDs    |
| **Donation**      | Logs donations made by customers                      |
| **Complain Box**  | Stores customer complaints                            |
| **Vault**         | Holds the bank's total balance                        |
| **Stuff**         | Stuffs data is store and stuff logins                 |


### <h3> Create database <h3>
```
    Create database echo_bank;
    use echo_bank;
```

### <h3>Customer Table</h3>

```sql
-- Customer Table
CREATE TABLE customer (
    account_number VARCHAR(12) NOT NULL PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    DOB DATE NOT NULL,
    NID VARCHAR(10) UNIQUE,
    address VARCHAR(255) NOT NULL,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    balance DECIMAL(18, 2) DEFAULT 0.00,
    status TINYINT(1) NOT NULL
);

```

### <h3>Account</h3>

```sql
-- Customer Table
CREATE TABLE account (
    account_number VARCHAR(12) NOT NULL FOREIGN KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    DOB DATE NOT NULL,
    NID VARCHAR(10) UNIQUE,
    balance DECIMAL(18, 2) DEFAULT 0.00,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP
);

```
<h3>Loan Table</h3>

```sql
-- Loan Table
CREATE TABLE loan (
    loan_id INT AUTO_INCREMENT PRIMARY KEY,
    loan_account_number VARCHAR(15) UNIQUE NOT NULL,
    account_number VARCHAR(12),
    username VARCHAR(50),
    cause VARCHAR(255),
    amount DECIMAL(18, 2),
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    status TINYINT(1) NOT NULL ,
    FOREIGN KEY (account_number) REFERENCES customer(account_number)
);
```

<h3>Transaction Table</h3>

```sql
-- Transaction Table
CREATE TABLE transaction (
    transaction_id INT AUTO_INCREMENT PRIMARY KEY,
    reference_id VARCHAR(10) UNIQUE NOT NULL,
    from_account VARCHAR(12),
    to_account VARCHAR(12),
    amount DECIMAL(18, 2) NOT NULL,
    transaction_type VARCHAR(20) NOT NULL CHECK (transaction_type IN ('deposit', 'withdrawal', 'transfer')),
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (from_account) REFERENCES customer(account_number),
    FOREIGN KEY (to_account) REFERENCES customer(account_number)
);
```
<h3>Donation Table</h3>

```sql
-- Donation Table
CREATE TABLE donation (
    donation_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    account_number VARCHAR(12),
    amount DECIMAL(18, 2) NOT NULL,
    FOREIGN KEY (account_number) REFERENCES customer(account_number)
);
```

<h3>Complain Box Table</h3>

```sql
-- Complain Box Table
CREATE TABLE complain_box (
    complain_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    account_number VARCHAR(12),
    cause VARCHAR(255) NOT NULL,
    status TINYINT(1) NOT NULL,
    FOREIGN KEY (account_number) REFERENCES customer(account_number)
);

```

<h3>Vault Table</h3>

```sql
-- Vault Table
CREATE TABLE vault (
    muster_account VARCHAR(12) not null,
    balance_cash DECIMAL(18, 2) NOT NULL,
    balance_electric DECIMAL(18, 2) NOT NULL
);
```

<h3>Stuff/Admin Table</h3>
they have default value for presentation  id: 12345 pass: admin

```sql
Create Table stuff (
    stuff_id int(5) ,
    stuff_name varchar(255),
    password varchar(50)
);
```

## <h2 id="sql-schema">📝 SQL Schema</h2>

You can find the complete SQL schema [[here](https://docs.com/](#sql-schema).

---

## <h2 id="er-diagram">📝 ER Diagram</h2>

Refer to the ER diagram [[here](https://app.diagrams.net/)](#er-diagram) for a visual representation of the database relationships.

