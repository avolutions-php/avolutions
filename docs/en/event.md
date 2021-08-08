# Event handling

* [Introduction](#introduction)
* [Create an Event](#create-an-event)
* [Create a Listener](#create-a-listener)
* [Register Listener for Events](#register-listener-for-events)
* [Dispatch an Event](#dispatch-an-event)
* [Application Events](#application-events)
  * [EntityEvents](#entityevents)

## Introduction

The AVOLUTIONS event implementation is a simple way to listen to different events created by the application.
Every raised event can be handled by one or multiple listeners.

## Create an Event

An Event is a simple class used as a container to store all information related to the event. It is passed to the Listener.
If no `name` attribute is defined for the event, the full class name (including namespace) is used as the Event name and has to be registered by this in the ListenerCollection.
Events have to be stored in the *application/Event* folder.
```php
namespace Application\Event;

use Avolutions\Event\Event;

class TestEvent extends Event
{
    protected string $name = 'TestEvent';

    public string $test = 'Lorem ipsum';
}
```
## Create a Listener

The Listener is a class which can contains several methods to handle Events. Listeners have to be stored in the *application/Listener* folder. 
The Listener to handle the *TestEvent* from our example above could look like this:

```php
namespace Application\Listener;

use Avolutions\Event\Event;

class TestEventListener
{
    public function handleEvent(Event $Event)
    {
        print $Event->getName().' : '.$Event->test;
    }
}
```
This will result in the following output:
```
TestEvent : Lorem Ipsum
```

## Register Listener for Events 
To connect a `Listener` to an `Event` the `ListenerCollection` is used. All Listener should be registered in the *events.php* file by using the `addListener()` method.
The `addListener()` method takes two arguments, the name of the Event and a callable (Listener class and method).
```php
$ListenerCollection->addListener('TestEvent', ['Application\Listener\TestEventListener', 'handleEvent']);
```

In this example the `handleEvent` method of the class `Application\Listener\TestEventListener` will be called every time the `TestEvent` is raised/dispatched.
## Dispatch an Event
To dispatch/raise an Event the EventDispatcher is used. You only need to create the Event and pass it to the *dispatch()* method:
```php
$event = new TestEvent();
EventDispatcher::dispatch($event);
```
## Application Events

There are several *built in* Events.

### EntityEvents
EntityEvents are automatically raised by the ORM module. There are the following events:

EntityEvent | Description | Parameters
--- | --- | ---
BeforeSave | This event is raised every time the *save()* method of an Entity is called. The Event is raised before the Entity is saved to the database. | $Entity - The saved Entity
 AfterSave | This event is raised every time the *save()* method of an Entity is called. The Event is raised after the Entity is saved to the database. | $Entity - The saved Entity.
BeforeUpdate | This event is raised every time the *save()* method of a existing Entity is called. The Event is raised before the Entity is saved to the database. | $Entity - The saved Entity. $EntityBeforeChange - The Entity before it was changed.
AfterUpdate | This event is raised every time the *save()* method of a existing Entity is called. The Event is raised after the Entity is saved to the database. | $Entity - The saved Entity. $EntityBeforeChange - The Entity before it was changed.
BeforeInsert | This event is raised every time the *save()* method of a new Entity is called. The Event is raised before the Entity is saved to the database. | $Entity - The saved Entity.
AfterInsert | This event is raised every time the *save()* method of a new Entity is called. The Event is raised after the Entity is saved to the database. | $Entity - The saved Entity.
BeforeDelete | This event is raised every time the *delete()* method of an Entity is called. The Event is raised before the Entity is deleted from the database. | $Entity - The deleted Entity.
 AfterDelete | This event is raised every time the *delete()* method of an Entity is called. The Event is raised after the Entity is deleted from the database. | $Entity - The saved Entity.

To handle EntityEvents it is just needed to create a Listener following naming conventions. The Listener class has to use the same name as the Entity followed by the string 'Listener'.
The methods to handle the EntityEvents needs to be named like the Event with the prefix 'handle'. For example if we want to handle the 'BeforeSave' Event of the Entity 'User', the Listener has to look like this:

```php
namespace Application\Listener;

class UserListener
{
    public function handleBeforeSave($Event)
    {

    }
}
```

A registration in the ListenerCollection is not necessary for `EntityEvents`.