namespace App;

data Person = Person { string $name, ?int $age };

namespace App\Domain\User;

data FirstName = FirstName { string $firstName };

namespace App\Domain\User\ValueObject {
    data UserId = UserId deriving (Uuid);
    data Name = String deriving (ToString, FromString);
    data Email = String deriving (ToString, FromString);
    data Person = Person { Name $name, Email[] $emails };
}

namespace App\Application\Command {
    data CreateUser = CreateUser { UserId $userId, Person $person } deriving (Command);
}

namespace Foo\Query {
    data FindUser = FindUser { UserId $userId } deriving (Query);
}

namespace Foo\DomainEvent {
    data UserCreated = UserCreated { UserId $userId, Person $person } deriving (DomainEvent);
}
