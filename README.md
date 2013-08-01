# Mbiz_CustomerNavigation

This module rewrite the block `Mage_Customer_Block_Account_Navigation`.

## New methods

The rewrited module creates 2 methods.

### updateLink

```php
public function updateLink($name, $path, $label, $urlParams = array())
```

This method allows to update a link with new information.

### deleteLink

```php
public function deleteLink($name);
```

This method allows to delete a link (or more if you pass an array as first parameter).

## Usage

The layout is your friend ;)

```xml
<customer_account>
    <!-- Update navigation -->
    <reference name="customer_account_navigation">
        <!-- Clean -->
        <action method="deleteLink">
            <link>billing_agreements</link>
            <link>recurring_profiles</link>
            <link>OAuth Customer Tokens</link>
            <link>downloadable_products</link>
        </action>

        <!-- Update some links -->
        <action method="updateLink" translate="label" module="customer">
            <name>account</name>
            <path>customer/account/</path>
            <label>My Dashboard</label>
        </action>
    </reference>
</customer_account>
```

