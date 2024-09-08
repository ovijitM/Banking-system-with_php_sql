# Echo Bank and Admin Database Management System

This project is a comprehensive database management system for a fictional bank, Echo Bank, and its administrative counterpart. The system handles various banking functionalities for customers, banks, and administrators, including account management, transactions, loan processing, and complaints. 

## Table of Contents
- [Database Structure](#database-structure)
  - [Database 1: Echo Bank](#database-1-echo-bank)
  - [Database 2: Admin](#database-2-admin)
- [Functionalities](#functionalities)
  - [Bank Side Functionalities](#bank-side-functionalities)
  - [User Side Functionalities](#user-side-functionalities)
  - [Admin Panel Functionalities](#admin-panel-functionalities)
- [Table Structures](#table-structures)

---

## Database Structure

### Database 1: Echo Bank

1. **customer_approve** - Stores information about approved customers.  
   **Fields:**  
   - `account_number`: 10-digit unique identifier for the account.  
   - `username`: Username of the customer.  
   - `password`: Encrypted password of the customer.  
   - `DOB`: Date of birth of the customer.  
   - `NID`: 10-digit National ID number.  
   - `timestamp`: Date and time when the account was approved.  
   - `Balance`: Current balance in the account.  
   - `status`: Account status (e.g., active, suspended).  

2. **customer_info** - Stores information about customer account requests.  
   **Fields:**  
   - `account_number`: 10-digit unique identifier for the account.  
   - `username`: Username of the customer.  
   - `password`: Encrypted password of the customer.  
   - `DOB`: Date of birth of the customer.  
   - `NID`: 10-digit National ID number.  
   - `timestamp`: Date and time of the account creation request.  
   - `Balance`: Initial balance.  

3. **transaction** - Stores transaction details between accounts.  
   **Fields:**  
   - `from_account`: Sender's account number.  
   - `to_account`: Receiver's account number.  
   - `amount`: Transaction amount.  
   - `transaction_type`: Type of transaction (e.g., deposit, withdrawal).  
   - `timestamp`: Date and time of the transaction.  

4. **loan_req** - Stores information about loan requests made by customers.  
   **Fields:**  
   - `account_number`: Customer's account number.  
   - `username`: Username of the customer.  
   - `cause`: Reason for the loan.  
   - `amount`: Loan amount requested.  
   - `timestamp`: Date and time of the request.  
   - `status`: Loan status (e.g., pending, approved).  

5. **loan_info** - Stores information about approved loans.  
   **Fields:**  
   - `account_number`: Customer's account number.  
   - `username`: Username of the customer.  
   - `cause`: Reason for the loan.  
   - `amount`: Approved loan amount.  
   - `timestamp`: Date and time of loan approval.  

6. **donation** - Stores details of donations made by customers.  
   **Fields:**  
   - `username`: Username of the donor.  
   - `account_number`: Donor's account number.  
   - `amount`: Donation amount.  

7. **complain_box** - Stores complaints submitted by users.  
   **Fields:**  
   - `username`: Username of the complainant.  
   - `account_number`: Complainant's account number.  
   - `cause`: Reason for the complaint.  
   - `status`: Status of the complaint (e.g., bank, user).  

### Database 2: Admin

1. **bank_approve** - Stores information about approved banks.  
   **Fields:**  
   - `bank_name`: Name of the bank.  
   - `bank_owner`: Owner of the bank.  
   - `initial_balance`: Initial balance of the bank.  
   - `approve`: Approval status of the bank.  

2. **bank_info** - Stores information about authorized banks.  
   **Fields:**  
   - `bank_name`: Name of the bank.  
   - `master_account_number`: Unique identifier for the bank's master account.  
   - `initial_balance`: Initial balance of the bank.  
   - `timestamp`: Date and time of bank authorization.  

---

## Functionalities

### Bank Side Functionalities

1. **Open Account**: Bank staff can approve account opening requests submitted by customers.
2. **Transaction History**: View the transaction history of any account.
3. **Deposit**: Add funds to a customer's account.
4. **Withdraw**: Withdraw funds from a customer's account.
5. **Fund Transfer**: Transfer funds between accounts within the bank.
6. **Loan Approval**: Review and approve or deny loan requests.
7. **User Approval**: Approve or reject user account requests.
8. **Loan Calculator**: Calculate loan amounts, interest, and repayment schedules.
9. **Complain List**: View and manage complaints submitted by customers.

### User Side Functionalities

1. **Account Open Request**: Submit a request to open an account if the user does not have one.
2. **Sign In**: Log in to the user account.
3. **Send Money**: Transfer money to another account.
4. **Pay Bill**: Pay bills using the account balance.
5. **Loan Apply**: Apply for a loan, specifying the amount and cause.
6. **Donation**: Donate funds to specified accounts or causes.
7. **Complain Box**: Submit complaints about services or issues.
8. **Loan Calculator**: Calculate possible loan terms and amounts.
9. **User Transaction History**: View personal transaction history.
10. **Dashboard**: View account balance, recent transactions, and other account information.

### Admin Panel Functionalities

1. **Bank Creation**: Create new banks within the system.
2. **Bank Authorization**: Approve new banks and set initial balances.
3. **Bank Balance Control**: Manage and control the balance of banks using the vault balance.

---

## Table Structures

```sql
-- Customer Approve Table
CREATE TABLE customer_approve (
    account_number VARCHAR(10) PRIMARY KEY,
    username VARCHAR(50),
    password VARCHAR(255),
    DOB DATE,
    NID VARCHAR(10),
    timestamp DATETIME,
    Balance DECIMAL(18, 2),
    status VARCHAR(20)
);

-- Customer Info Table
CREATE TABLE customer_info (
    account_number VARCHAR(10),
    username VARCHAR(50),
    password VARCHAR(255),
    DOB DATE,
    NID VARCHAR(10),
    timestamp DATETIME,
    Balance DECIMAL(18, 2)
);
-- Transaction Table
CREATE TABLE transaction (
    from_account VARCHAR(10),
    to_account VARCHAR(10),
    amount DECIMAL(18, 2),
    transaction_type VARCHAR(20),
    timestamp DATETIME
);

-- Loan Request Table
CREATE TABLE loan_req (
    account_number VARCHAR(10),
    username VARCHAR(50),
    cause VARCHAR(255),
    amount DECIMAL(18, 2),
    timestamp DATETIME,
    status VARCHAR(20)
);
-- Loan Info Table
CREATE TABLE loan_info (
    account_number VARCHAR(10),
    username VARCHAR(50),
    cause VARCHAR(255),
    amount DECIMAL(18, 2),
    timestamp DATETIME
);
-- Donation Table
CREATE TABLE donation (
    username VARCHAR(50),
    account_number VARCHAR(10),
    amount DECIMAL(18, 2)
);
-- Complain Box Table
CREATE TABLE complain_box (
    username VARCHAR(50),
    account_number VARCHAR(10),
    cause VARCHAR(255),
    status VARCHAR(20)
);

-- Bank Approve Table
CREATE TABLE bank_approve (
    bank_name VARCHAR(50),
    bank_owner VARCHAR(50),
    initial_balance DECIMAL(18, 2),
    approve BOOLEAN
);
-- Bank Info Table
CREATE TABLE bank_info (
    bank_name VARCHAR(50),
    master_account_number VARCHAR(10),
    initial_balance DECIMAL(18, 2),
    timestamp DATETIME
);
