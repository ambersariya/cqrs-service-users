// Generating immutable types for CQRS/ES
namespace App\Application\Query\User\GetAllUsers;

data GetAllUsers = GetAllUsers {} deriving (Query);
data GetAllUsersHandler = GetAllUsersHandler {};

namespace App\Domain\User;

data UserId = UserId {} deriving(Uuid);