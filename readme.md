# Backend engineer Test
My main objetive has been to restructure the code to be more understandable considering the possibility in the future to create a new features. Below, I detail part of that effor:

### Comments
Improve of comments on methods:
- Functionality description
- @params. Parameters that it receives
- @return. Value type that returns.

### Strategy Pattern
Because depending on some factors it's necessary to create rewardPoints differently then I've used the strategy pattern to independently separate those operations and in this case the main class of the Case of Use as Context. 

### Exception control
I've considered controlling exceptions to possible fatal errors.

### Unit test
I've created some unit tests and so can test the behavior of classes and methods separately.
- CashbackRewardTest
- ChangeRewardStateUseCaseExceptionTest
- ChangeRewardStateUseCaseTest