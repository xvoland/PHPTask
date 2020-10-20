# PHPTask
## Scenario
We need to build an order dispatch system, for sending out customer orders with one of a number of different couriers.
At the start of a normal working day, a new batch will be started, and it will be closed at the end of the day, when no more parcels are going to be shipped. This is called the dispatch period.
Each parcel sent out with a courier is called a consignment. Each consignment will be given a unique number - each courier will supply an algorithm for generating their own format of consignment numbers.
At the end of each dispatch period, a list of all the consignment numbers needs to be sent to each individual courier. The method of data transport varies from courier to courier (e.g. Royal Mail use email, ANC use anonymous FTP).

### What should produce:
Build a class structure to facilitate the implementation of the scenario set out above. Assume that your class library will be given to another developer at a later date to build the interface for the client.

*The client interface will have three primary functions:*

1. Start new batch
2. Add consignment
3. End current batch

## Screenshots of processes

### batchmail.php interface

![image](https://github.com/xvoland/PHPTask/raw/main/images/img01.png)

### batchmail.php result of add/create batch "Start New Batch"

![image](https://github.com/xvoland/PHPTask/raw/main/images/img02.png)

### batchmail.php result of added for button "List Of Batches"

![image](https://github.com/xvoland/PHPTask/raw/main/images/img03.png)

### batchmail.php SQL record as a result 

![image](https://github.com/xvoland/PHPTask/raw/main/images/img03_01.png)

### index.php main interface

![image](https://github.com/xvoland/PHPTask/raw/main/images/img04.png)

### index.php completed form for Batch with Id:1

![image](https://github.com/xvoland/PHPTask/raw/main/images/img05.png)

### index.php result of add record into database

![image](https://github.com/xvoland/PHPTask/raw/main/images/img06.png)

### index.php added record into database

![image](https://github.com/xvoland/PHPTask/raw/main/images/img06_01.png)

