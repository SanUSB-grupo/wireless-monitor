# Troubleshooting

Maximum function nesting level of '100' reached, aborting!

Add the following to your `/etc/php5/cli/php.ini`:

~~~ini
[xdebug]
xdebug.max_nesting_level = 200
~~~
