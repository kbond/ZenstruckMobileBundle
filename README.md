# ZenstruckMobileBundle

Adds various tools to help with mobile development in Symfony2.

## Mobile Manager

The ``zenstruck_mobile.manager`` service stores whether or not the current request
is a mobile one.

### Setup

In your ``config.yml``:

    zenstruck_mobile:
        full_host: example.com
        mobile_host: m.example.com

You can also set the mobile status of the current environment (ie ``config_mobile.yml``):

    zenstruck_mobile:
        mobile: true/false

This allows you to have a vhost point to ``index.php`` which enables the ``full``
environment and another vhost point to ``mobile.php`` which enables the ``mobile``
environment.

### Examples

    <?php

    $this->container->get('zenstruck_mobile.manager')->isMobile(); // true or false
    $this->container->get('zenstruck_mobile.manager')->getMobile(); // false or 'mobile'
    $this->container->get('zenstruck_mobile.manager')->getMobileHost(); // your mobile_host set in config.yml
    $this->container->get('zenstruck_mobile.manager')->getFullHost(); // your full_host set in config.yml

## Listener

To have both your full and mobile site be in the same environment this bundle comes
with an event listener.  The listener compares the current request's host name to the
``mobile_host`` you set in your ``config.yml``.  If a match is found the manager's
mobile flag is set to true.

Enable/Disable the listener in your ``config.yml``:

    zenstruck_mobile:
        use_listener: true/false

## Twig Helper

There are twig functions that allow you to generate your full/mobile urls.

Enable/Disable them in your ``config.yml``:

    zenstruck_mobile:
        use_helper: true/false

Use them in your twig templates as follows:

    {{ zenstruck_mobile_url() }} {# generates mobile url #}
    {{ zenstruck_mobile_full_url() }} {# generates full url #}
    {{ zenstruck_mobile_is_mobile() }} {# true if mobile #}

### Optional Parameters

* ``zenstruck_mobile_url()`` and ``zenstruck_mobile_full_url()``:
  * ``parameters``: an array of parameters to be added to the url - useful for
    setting a mobile query flag to be used to set a user cookie. **Default**:
    *empty array*
  * ``prefix``: the default scheme. **Default**: http://

### Examples

    {# generate mobile url and set a ?mobile=true parameter #}
    {{ zenstruck_mobile_url({'mobile': 1}) }}

    {# generate full url, set a ?mobile=true parameter and set the prefix to https:// #}
    {{ zenstruck_mobile_full_url({'mobile': 0, 'prefix': 'https://'}) }}

### Suggested Usage

1. Create 3 layouts: ``full.html.twig``, ``mobile.html.twig`` ``layout.html.twig``.
2. Add the following to ``layout.html.twig``:

        {% extends zenstruck_mobile_is_mobile() ? "MyBundle::mobile.html.twig" : "MyBundle::full.html.twig" %}

3. Have all your templates extend ``layout.html.twig``  If the request is a mobile
   one your templates will be *decorated* with ``mobile.html.twig``.

## Custom TwigEngine

This bundle comes with a custom twig engine.  It allows you to have mobile templates
that are automatically rendered on a mobile request if they exist.

For example:

    $this->container->get('templating')->render('MyBundle:Default:index.html.twig');

Will render the ``MyBundle:Default:index.html.twig`` template as normal on full
site but on a mobile request it will look for ``MyBundle:Default:mobile/index.html.twig``.
If found it will render the mobile template, if not, it will render the default full one.
Simply create a *mobile* folder in the same directoy as your full template and create a
template with the same name in it.

Enable/Disable the custom twig engine in your config.yml:

    zenstruck_mobile:
        use_twig_engine: true/false

# Full Default Configuration

    zenstruck_mobile:
        mobile: false
        use_listener: true
        use_helper: true
        use_twig_engine: false
        full_host: ~ # Required
        mobile_host: ~ # Required

# Reference

Possible settings for ``.htaccess`` to handle mobile detection and redirect.  This
also allows a mobile device to *override* the redirect if a cookie is set.  See the
**Twig Helper** example above to see how to set the ``mobile`` parameter.

    <IfModule mod_rewrite.c>
        RewriteBase /
        RewriteEngine On

        # Check if mobile=1 is set and set cookie 'mobile' equal to 1
        RewriteCond %{QUERY_STRING} (^|&)mobile=1(&|$)
        RewriteRule ^ - [CO=mobile:1:%{HTTP_HOST}]

        # Check if mobile=0 is set and set cookie 'mobile' equal to 0
        RewriteCond %{QUERY_STRING} (^|&)mobile=0(&|$)
        RewriteRule ^ - [CO=mobile:0:%{HTTP_HOST}]

        # cookie can't be set and read in the same request so check
        RewriteCond %{QUERY_STRING} (^|&)mobile=0(&|$)
        RewriteRule ^ - [S=1]

        # Check if this looks like a mobile device
        RewriteCond %{HTTP:x-wap-profile} !^$ [OR]
        RewriteCond %{HTTP_USER_AGENT} "android|blackberry|ipad|iphone|ipod|iemobile|opera mobile|palmos|webos|googlebot-mobile" [NC,OR]
        RewriteCond %{HTTP:Profile}       !^$

        # Check if we're not already on the mobile site
        RewriteCond %{HTTP_HOST}          !^m\.
        # Check to make sure we haven't set the cookie before
        RewriteCond %{HTTP:Cookie}        !\mobile=0(;|$)
        # Now redirect to the mobile site
        RewriteRule ^ http://m.example.com%{REQUEST_URI} [R,L]

        # Symfony
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^(.*)$ app.php [QSA,L]
    </IfModule>


#TODO

* allow for different templates (mobile/iphone/ipad etc.) - I do not have a use case
  but if someone wants to do this create a PR
* allow the different templates to have fallbacks (if no ipad, use iphone, if
  no iphone then use mobile) - again, no use case for myself but send a PR