#Sample calls

Assumes that you already installed and configured Chibex\Ozioma. And that you have created and
configured the $ozioma object as you want. Check [README](README.md) for details.

``` php
// Make a call to the resource/method
// $ozioma->{resource}->{method}();
// for gets, use $ozioma->{resource}(id)
// for lists, use $ozioma->{resource}s()

// balance
$ozioma->balance->check();

// month
$ozioma->month->list();

// timezone
$ozioma->timezone->list();

// message
$ozioma->message->fetch(1);
$ozioma->message->getExtras(1);

// newsletter
$ozioma->newsletter->list();

// birthday
$ozioma->birthday->getGroupList();

```
