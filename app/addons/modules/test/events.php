<?php

Event::listen(
    'test.test_event',
    function () {
        echo 'The test.test_event has been triggered! - ';
    }
);
