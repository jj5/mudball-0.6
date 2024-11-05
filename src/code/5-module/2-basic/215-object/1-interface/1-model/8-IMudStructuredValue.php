<?php

// 2024-07-29 jj5 - a "structured value" is a composite value which has a well defined canonical string format, such
// as with email addresses, URLs, and dates.  This interface is for structured values which are not necessarily
// atomic, such as with dates and times.

interface IMudStructuredValue extends IMudComposite {

}
