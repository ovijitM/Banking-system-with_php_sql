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
- [📜 HTML Format](#html-format)

---

## <h2 id="database-structure">🏦 Database Structure</h2>

### <h3>Tables</h3>

1. **Customer Table**: Stores all customer details, including approved and pending accounts.
2. **Loan Table**: Stores details about loan requests and approvals with unique loan account numbers.
3. **Transaction Table**: Records all transactions with unique reference IDs for each.
4. **Donation Table**: Stores details of donations made by customers.
5. **Complain Box Table**: Stores complaints submitted by customers.
6. **Vault Table**: Holds the balance of the bank's vault.

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
| **Loan**          | Manages loan requests and approvals                   |
| **Transaction**   | Records all transactions with unique reference IDs    |
| **Donation**      | Logs donations made by customers                      |
| **Complain Box**  | Stores customer complaints                            |
| **Vault**         | Holds the bank's total balance                        |

### <h3>Customer Table</h3>

```sql
-- Customer Table
CREATE TABLE customer (
    account_number VARCHAR(10) PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    DOB DATE NOT NULL,
    NID VARCHAR(10) UNIQUE NOT NULL,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    balance DECIMAL(18, 2) DEFAULT 0.00,
    status VARCHAR(20) NOT NULL CHECK (status IN ('pending', 'approved'))
);
```
<h3>Loan Table</h3>

```sql
-- Loan Table
CREATE TABLE loan (
    loan_id INT AUTO_INCREMENT PRIMARY KEY,
    loan_account_number VARCHAR(15) UNIQUE NOT NULL,
    account_number VARCHAR(10),
    username VARCHAR(50),
    cause VARCHAR(255),
    amount DECIMAL(18, 2),
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(20) CHECK (status IN ('pending', 'approved')),
    FOREIGN KEY (account_number) REFERENCES customer(account_number)
);
```
<h2 id="sql-schema">📝 SQL Schema</h2>

<h3>Transaction Table</h3>

```sql
-- Transaction Table
CREATE TABLE transaction (
    transaction_id INT AUTO_INCREMENT PRIMARY KEY,
    reference_id VARCHAR(20) UNIQUE NOT NULL,
    from_account VARCHAR(10),
    to_account VARCHAR(10),
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
    account_number VARCHAR(10),
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
    account_number VARCHAR(10),
    cause VARCHAR(255) NOT NULL,
    status VARCHAR(20) CHECK (status IN ('resolved', 'pending')),
    FOREIGN KEY (account_number) REFERENCES customer(account_number)
);

```

<h3>Vault Table</h3>

```sql
-- Vault Table
CREATE TABLE vault (
    vault_id INT PRIMARY KEY AUTO_INCREMENT,
    balance DECIMAL(18, 2) NOT NULL
);
```
