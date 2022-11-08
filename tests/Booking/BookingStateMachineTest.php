<?php

declare(strict_types=1);

namespace App\Tests\Booking;

use App\Booking\Model\Booking;
use App\Booking\Model\Request;
use App\Booking\Service\BookingStateMachine;
use App\Booking\State\DraftState;
use App\Customer\Model\Client;
use App\Vendor\Model\Availability;
use App\Vendor\Model\Calendar;
use App\Vendor\Model\Doctor;
use DateTimeImmutable;
use Money\Money;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BookingStateMachineTest extends KernelTestCase
{
    private readonly array $doctors;

    protected function setUp(): void
    {
        $this->doctors = [
            'John' => new Doctor('John', new Calendar([new Availability(new DateTimeImmutable('tomorrow 09:00'), Money::EUR(1000))])),
            'Anna' => new Doctor('Anna', new Calendar([new Availability(new DateTimeImmutable('next week 10:00'), Money::EUR(2000))])),
            'Smith' => new Doctor('Smith', new Calendar([new Availability(new DateTimeImmutable('next month 11:00'), Money::EUR(3000))])),
        ];
    }

    public function testPlannedOpenSideRequestBookingHappyPath(): void
    {
        /** @var DraftState $initialState */
        $initialState = self::getContainer()->get(DraftState::class);
        $stateMachine = new BookingStateMachine($initialState);

        $client = new Client('Jane');
        $doctor = $this->doctors['John'];
        $date = new DateTimeImmutable('tomorrow 09:00');
        $request = new Request($client, $doctor, $date);

        $stateMachine->request($request);
        self::assertTrue($request->status()->isWaiting());

        $booking = $stateMachine->process($request);
        self::assertTrue($request->status()->isComplete());
        self::assertTrue($booking->status()->isPending());
        self::assertEquals($doctor, $booking->doctor());
        self::assertCount(1, $client->bookings());
        self::assertCount(1, $doctor->bookings());
        self::assertEquals($date, $booking->date());

        $stateMachine->accept($booking);
        self::assertTrue($booking->status()->isAccepted());
        self::assertNull($doctor->calendar()->nextAvailability());

        $stateMachine->execute($booking);
        self::assertTrue($booking->status()->isExecuting());

        $stateMachine->finish($booking);
        self::assertTrue($booking->status()->isFinished());
    }

    public function testOnDemandOpenSideBooking(): void
    {
        $client = new Client('Jane');
        $request = new Request($client, $this->doctors['Anna'], null);

        $this->markTestSkipped('Pending.');
    }

    public function testPlannedBlindSideBooking(): void
    {
        $client = new Client('Jane');
        $request = new Request($client, null, new DateTimeImmutable('next month 11:00'));

        $this->markTestSkipped('Pending.');
    }

    public function testOnDemandBlindSideBooking(): void
    {
        $client = new Client('Jane');
        $request = new Request($client, null, null);

        $this->markTestSkipped('Pending.');
    }
}
