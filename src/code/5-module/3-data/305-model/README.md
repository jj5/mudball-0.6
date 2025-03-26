
In the PHP code it's 'app' for application defined objects and 'mud' for framework defined objects.

In the database it's 'bus' for application defined tables and 'std' for framework defined tables.

There are various types of ID:

 aid = auto_increment
 iid = internal ID
 xid = external ID

Properties can only be added to the end of objects, they cannot be removed.

Properties can be renamed or have their data type changed so long as they remain in the same position. If this happens
an alias should be made from the old name to the new name in the ORM.

The idea is that the latest model and the latest schema are serialized and deserialized in the client. The full versions
are only loaded when needed for database administration and reporting purposes.
