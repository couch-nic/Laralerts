<?php

namespace DarkGhostHunter\Laralerts\Tests;

use Orchestra\Testbench\TestCase;
use DarkGhostHunter\Laralerts\Alert;
use DarkGhostHunter\Laralerts\AlertBag;
use PHPUnit\Framework\AssertionFailedError;
use DarkGhostHunter\Laralerts\Testing\WithAlerts;

class AssertionsTest extends TestCase
{
    use Concerns\RegistersPackage, WithAlerts;

    public function testAssertHasAnyAlert()
    {
        /** @var AlertBag $bag */
        $bag = $this->app[AlertBag::class];

        $bag->add(new Alert('test'));

        $this->assertHasAnyAlert();
    }

    public function testAssertHasAnyAlertFails()
    {
        $this->expectException(AssertionFailedError::class);

        $this->assertHasAnyAlert();
    }

    public function testAssertDoesntHaveAlerts()
    {
        $this->assertDoesntHaveAlerts();
    }

    public function testAssertDoesntHaveAlertsFails()
    {
        $this->expectException(AssertionFailedError::class);

        /** @var AlertBag $bag */
        $bag = $this->app[AlertBag::class];

        $bag->add(new Alert('test'));

        $this->assertDoesntHaveAlerts();
    }

    public function testAssertHasAlert()
    {
        /** @var AlertBag $bag */
        $bag = $this->app[AlertBag::class];

        $bag->add(new Alert('test_message', 'test_type'));

        $this->assertHasAlert('test_message');
        $this->assertHasAlert('test_message', 'test_type');
    }

    public function testAssertHasAlertFailsWhenOnlyMessage()
    {
        $this->expectException(AssertionFailedError::class);

        /** @var AlertBag $bag */
        $bag = $this->app[AlertBag::class];

        $bag->add(new Alert('test_message', 'test_type'));

        $this->assertHasAlert('foo');
    }

    public function testAssertHasAlertFailsWhenMessageAndType()
    {
        $this->expectException(AssertionFailedError::class);

        /** @var AlertBag $bag */
        $bag = $this->app[AlertBag::class];

        $bag->add(new Alert('test_message', 'test_type'));

        $this->assertHasAlert('test_message', 'bar');
    }

    public function testAssertDoesntHaveAlert()
    {
        /** @var AlertBag $bag */
        $bag = $this->app[AlertBag::class];

        $bag->add(new Alert('test_message', 'test_type'));

        $this->assertDoesntHaveAlert('foo');
        $this->assertDoesntHaveAlert('foo', 'test_type');
        $this->assertDoesntHaveAlert('test_message', 'bar');
    }

    public function testAssertDoesntHaveAlertFailsWhenMessage()
    {
        $this->expectException(AssertionFailedError::class);

        /** @var AlertBag $bag */
        $bag = $this->app[AlertBag::class];

        $bag->add(new Alert('test_message', 'test_type'));

        $this->assertDoesntHaveAlert('test_message');
    }

    public function testAssertDoesntHaveAlertFailsWhenMessageAndType()
    {
        $this->expectException(AssertionFailedError::class);

        /** @var AlertBag $bag */
        $bag = $this->app[AlertBag::class];

        $bag->add(new Alert('test_message', 'test_type'));

        $this->assertDoesntHaveAlert('test_message', 'test_type');
    }

    public function testAssertAlertsCount()
    {
        /** @var AlertBag $bag */
        $bag = $this->app[AlertBag::class];

        $bag->add(new Alert('test_message_foo', 'test_type_foo'));
        $bag->add(new Alert('test_message_bar', 'test_type_bar'));
        $bag->add(new Alert('test_message_baz', 'test_type_baz'));
        $bag->add(new Alert('test_message_qux', 'test_type_qux'));

        $this->assertAlertsCount(4);
    }

    public function testAssertAlertsCountFailsWhenBelowExpected()
    {
        $this->expectException(AssertionFailedError::class);

        /** @var AlertBag $bag */
        $bag = $this->app[AlertBag::class];

        $bag->add(new Alert('test_message_foo', 'test_type_foo'));
        $bag->add(new Alert('test_message_bar', 'test_type_bar'));
        $bag->add(new Alert('test_message_baz', 'test_type_baz'));
        $bag->add(new Alert('test_message_qux', 'test_type_qux'));

        $this->assertAlertsCount(3);
    }

    public function testAssertAlertsCountFailsWhenOverExpected()
    {
        $this->expectException(AssertionFailedError::class);

        /** @var AlertBag $bag */
        $bag = $this->app[AlertBag::class];

        $bag->add(new Alert('test_message_foo', 'test_type_foo'));
        $bag->add(new Alert('test_message_bar', 'test_type_bar'));
        $bag->add(new Alert('test_message_baz', 'test_type_baz'));
        $bag->add(new Alert('test_message_qux', 'test_type_qux'));

        $this->assertAlertsCount(5);
    }

    public function testAssertAlertsCountFailsWhenEmpty()
    {
        $this->expectException(AssertionFailedError::class);

        $this->assertAlertsCount(5);
    }
}
