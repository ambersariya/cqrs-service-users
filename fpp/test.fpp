// Generating immutable types for CQRS/ES
namespace App\Application\Query\User\GetAllUsers;

data GetAllUsers = GetAllUsers {} deriving (Query);
data GetAllUsersHandler = GetAllUsersHandler {};
