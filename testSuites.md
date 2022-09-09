# testsuites Element
**parent element: `phpunit`**
this elements is the root for one or more `<testsuite>` elements that are used to configure the tests that are to be executed.

---
# `testsuite` Element
**parent element: `<testsuites>`**

a `<testsuite>` element must have a `name` attribute and may have one or more `<directory>` and / or `<file>` child elements that configure directories and / or files, respectively, that should be searched for tests.

```
<testsuites>
  <testsuite name="unit">
    <directory>tests/unit</directory>
  </testsuite>

  <testsuite name="integration">
    <directory>tests/integration</directory>
  </testsuite>

  <testsuite name="edge-to-edge">
    <directory>tests/edge-to-edge</directory>
  </testsuite>
</testsuites>
```
using the `phpVersion` and `phpVersionOperator` attributes, a required PHP version can be specified:
```
<testsuites>
  <testsuite name="unit">
    <directory phpVersion="8.0.0" phpVersionOperator=">=">tests/unit</directory>
  </testsuite>
</testsuites>
```
in the example above, the tests from the `tests/unit` directory are only added to the test suite if the PHP version is at least 8.0.0. The `phpVersionOperator` attribute is optional and default: `>=`
