// Generating immutable types for CQRS/ES
//namespace App\Domain\ValueObject;
//
//data Email = Email { string $email } deriving (ToString, FromString) where
//	_:
//		|   filter_var($email, FILTER_VALIDATE_EMAIL) === false => 'Email is not valid';
//
//namespace App\Domain\ValueObject\Auth;
//
//data Credentials = Credentials { Email $email, HashedPassword $password };
//
//namespace App\Domain\User;
//
//data UserId = UserId {} deriving (Uuid);
//
namespace App\Application\Query\User\GetAllUsers;

data GetAllUsers = GetAllUsers {} deriving (Query);
data GetAllUsersHandler = GetAllUsersHandler {};

//namespace App\Application\Command\User\ChangeEmailAddress;
//
//data ChangeEmailAddressCommand = ChangeEmailAddressCommand { \App\Domain\UserId $userId, \App\Domain\ValueObject\Email $email } deriving (Command);
//
//namespace App\Domain\Event\ChangedCredentials;
//
////data ChangedEmailAddressEvent = ChangedEmailAddressEvent { \App\Domain\UserId $userId, \App\Domain\ValueObject\Email $email } deriving (AggregateChanged);
//data ChangedCredentialsEvent = ChangedCredentialsEvent { \App\Domain\UserId $userId, \App\Domain\ValueObject\Auth\Credentials $credentials } deriving (AggregateChanged);
