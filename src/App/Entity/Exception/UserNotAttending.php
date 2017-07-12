<?php
declare(strict_types = 1);

namespace App\Entity\Exception;

use App\Entity\Meetup;
use App\Entity\User;

final class UserNotAttending extends \DomainException
{
    public static function fromMeetupAndUser(Meetup $meetup, User $user) : self
    {
        return new self(sprintf(
            'User "%s" is not attending the meetup on "%s" so cannot be checked in',
            $user->displayName(),
            $meetup->getFromDate()->format('Y-m-d')
        ));
    }
}
