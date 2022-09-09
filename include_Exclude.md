# include element
**parent element: `<coverage>`**

configures a set of files to be include in code coverage reports
```
<include>
    <directory suffix=".php">src</directory>
</include>
```
the example shown above instructs PHPUnit to include all sourcecode files with `.php` suffix in the `src` directory and its sub-directories in the code coverage reports.



---
# `exclude` Element
---
**parent element: `<coverage>`**

configures a set of files to be excluded from code coverage reports.
```
<include>
    <directory suffix=".php">src</directory>
</include>

<exclude>
    <directory suffix=".php">src/generated</directory>
    <file>src/autoload.php</file>
</exclude>
```
the example shown above instructs PHPUnit to include all sourcecode files with `.php` suffix in the `src` directory and its sub-directories in the code coverage report but exclude all files with `.php` suffix in the `src/generated` directory and its sub-directories as well as teh `src/autoload.php` file from the code coverage reports.


# `<directory>` Element
**parent elements: `<include>`, `<exclude>`**
configures a directory and its sub-directories for inclusion in or exclusion from code coverage reports.

---
## `prefix` attribute
---
**possible values: `string`**

configures a prefix-based filter that is applied to the names of files in the directory and its sub-directories.

---
## `suffix` attribute
---
**possible values: `string` default: `.php`**

configures a suffix-based filter that is applied to the names of files in the directory and its sub-directories.

---
## `phpVersionOperator` attribute
---
**possible values: `<`,`lt`,`<=`,`le`,`>`,`gt`,`>=`,`ge`,`==`,`eq`,`!=`, `<>`,`ne` default: `>=`**

configures the comparison operator to be used with `version_compare()` for the filter based on the version of the PHP runtime that is used to run the current PHPUnit process.

# `file` Element
**parent elements: `<include>`, `<exclude>`**

configures a file for inclusion in or exclusion from code coverage reports.

# `report` Element
**parent elements: `<coverage>`**
```
<report>
    <clover outputFile="clover.xml"/>
    <cobertura outputFile="cobertura.xml"/>
    <crap4j outputFile="crap4j.xml" threshold="50"/>
    <html outputDirectory="html-coverage" lowUpperBound="50" highLowerBound="90"/>
    <php outputFile="coverage.php"/>
    <text outputFile="coverage.txt" showUncoveredFiles="false" showOnlySummary="true"/>
    <xml outputDirectory="xml-coverage"/>
</report>
```

# `clover` Element
**parent element: `<report>`**

configures a code coverage report in Clover XML format.

---
## `outputFile` attribute
---

**possible values: `string`**
the file to which the clover xml report is written

---
# `cobertura` Element
**parent element: `<report>`**
configures a code coverage report in Cobertura XML format

---
## `outputFile` attribute
---
**possible values: `string`**

the file to which the Cobertura XML report is written

# `crap4j` Element
**parent element: `<report>`**

configures a code coverage report in Crap4J  XML format

---
## `outputFile` attribute
---
**possible values: `string`**

the file to which the Crap4J XML report is written

---
## `threshold` attribute
---
**possible values: `integer`, default: `50`**

# `html` Element
**parent element: `<report>`**

configures a code coverage report in HTML format

---
## `outputDirectory` attribute
---
the directory to which the HTML report is written

---
## `lowUpperBound` attribute
---
**possible values: `integer` default: `50`**

the upper bound of what should be considered "low coverage"

---
## `highLowerBound` attribute
---
**possible values: `integer` default: `90`**

the upper bound of what should be considered "high coverage"


# `php` Element
**parent element: `<report>`**

configures a code coverage report in PHP format

---
## `outputFile` attribute
---

**possible values: `string`**
the file to which the php report is written

# `text` Element
**possible values: `string`**

configure a code coverage report in text format


---
## `outputFile` attribute
---

**possible values: `string`**
the file to which the php text report is written

---
## `showUncoveredFiles` attribute
---
**possible values: `true` or `false` default:`false`**

---
## `showOnlySummary` attribute
---
**possible values: `true` or `false` default:`false`**


# `xml` Element
**parent element: `<report>`**

configures a code coverage report in PHPUnit XML format

---
## `outputDirectory` attribute
---
**possible values: `string`**
the directory to which the PHPUnit XML report is written


# `logging` Element
**parent element: `<phpunit>`**

the `logging` element and its children can be used to configure the logging of the test execution.
```
<logging>
    <junit outputFile="junit.xml"/>
    <teamcity outputFile="teamcity.txt"/>
    <testdoxHtml outputFile="testdox.html"/>
    <testdoxText outputFile="testdox.txt"/>
    <testdoxXml outputFile="testdox.xml"/>
    <text outputFile="logfile.txt"/>
</logging>
```

# `junit` Element
**parent element: `<logging>`**

configures a test result logfile in JUnit XML format

---
## `outputFile` attribute
**possible values: `string`**
the file to which the test result logfile in JUnit XML format is written

# `teamcity` Element
**parent element: `<logging>`**
configures a test result logfile in TeamCity format

# `testdoxHtml` Element
**parent element: `<logging>`**
configures a test result logfile in TestDox HTML format

---
## `outputFile` attribute
---
**possible values: `string`**

the file to which the test result logfile in TestDoxHtml format is written.


# `testdoxText` Element
**parent element: `<logging>`**

configure a test result logfile in TestDox text format.

---
## `outputFile` attribute
---
**possible values: `string`**

the file to which the test result logfile in TestDoxHtml format is written.



# `testdoxXml` Element
**parent element: `<logging>`**

configure a test result logfile in TestDox XML format.

---
## `outputFile` attribute
---
**possible values: `string`**

the file to which the test result logfile in TestDox XML format is written.

# `text` Element
**parent element: `<logging>`**

configures a test result logfile in text format

---
## `outputFile` attribute
---
**possible values: `string`**

the file to which the test result logfile in TestDox Text format is written

# `groups` Element
**parent element: `<phpunit>`**

the `<groups>` element and its `<include>`, `<exclude>` and `<group>` children can be used to select groups of tests marked with the `@group` annotation that should(not) be run:
```
<groups>
  <include>
    <group>name</group>
  </include>
  <exclude>
    <group>name</group>
  </exclude>
</groups>
```

the example shown above is equivalent to invoking the PHPUnit test runner with `--group name --exclude-group name`


# `listeners` Element
**parent element: `<phpunit>`**

the `<listener>` element and its `<lister>` children can be used to attach addittional test listeners to the test execution.

# `listener` Element
**parent element: `<listeners>`**

```
<listeners>
  <listener class="MyListener" file="/optional/path/to/MyListener.php">
    <arguments>
      <array>
        <element key="0">
          <string>Sebastian</string>
        </element>
      </array>
      <integer>22</integer>
      <string>April</string>
      <double>19.78</double>
      <null/>
      <object class="stdClass"/>
    </arguments>
  </listener>
</listeners>
```
the XML configuration above corresponds to attaching the `$listener` object (see below) to the test execution:
```
$listener = new MyListener(
    ['Sebastian'],
    22,
    'April',
    19.78,
    null,
    new stdClass
);
```
*NOTE: the `PHPUnit\Framework\TestListener` interface is deprecated and will be removed in the future. testRunner extensions should be used instead of test listeners*






# `extensions` Elements
**parent element: `<phpunit>`**

the `<extensions>` element and its `<extension>` children can be used to register test runner extensions.

# `extension` Element
**parent element: `<extensions>`**
```
<extensions>
    <extension class="Vendor\MyExtension"/>
</extensions>
```

# `arguments` Element
**parent element: `<extension>`**

the `<arguments>` element can be used to configure a single `<extension>`

accepts a list of elements of types, which are then used to configure individual extensions. the arguments are passed to the extension class `__constructor` method in the order they are defined in the configuration.
**available  types:**
- `boolean`
- `integer`
- `string`
- `double | float`
- `array`
- `object`

```
<extension class="Vendor\MyExtension">
    <arguments>
        <integer>1</integer>
        <integer>2</integer>
        <integer>3</integer>
        <string>hello world</string>
        <boolean>true</boolean>
        <double>1.23</double>
        <array>
            <element index="0">
                <string>value1</string>
            </element>
            <element index="1">
                <string>value2</string>
            </element>
        </array>
        <object class="Vendor\MyPhpClass">
            <string>constructor arg 1</string>
            <string>constructor arg 2</string>
        </object>
    </arguments>
</extension>
```

# `php` Element
**parent element: `<phpunit>`**

the `<php>` element and its children can be used to configure PHP settings, constants and global variables. it can also be used to prepend the `include_path`

# `includePath` Element
**parent element: `<php>`**

this element can be used to prepend a path to the `include_path`

# `ini` Element
**parent element: `<php>`**

this element can be used to set a php configuration setting
```
<php>
  <ini name="foo" value="bar"/>
</php>
```
the XML configuration above corresponds to the following php code:
` ini_set('foo','bar');`

# `const` Element
this element can be used to set a global constant
```
<php>
  <const name="foo" value="bar"/>
</php>
```
corresponds to :
` define('foo','bar');`

# `var` Element
**parent element: `<app>`**

this element can be used to set a **global** variable
 ```
 <php>
  <var name="foo" value="bar"/>
</php>
```
corresponds to: `$GLOBALS['foo'] = 'bar';`

# `env` Element
**parent element: `<php>`**

this element can be used to set a value in the super-global array `$_ENV`
```
<php>
  <env name="foo" value="bar"/>
</php>
```
corresponds to : `$_ENV['foo']='bar';`

by default, environment variables are not overwritten if they exist already. to force overwriting existing variables, use the `force` attribute:
```
<php>
  <env name="foo" value="bar" force="true"/>
</php>
```


# `get` Element
**parent element: `<php>`**

this element can be used to set a value in the super-global array: `$_GET`
```
<php>
  <get name="foo" value="bar"/>
</php>
```
The XML configuration above corresponds to the following PHP code:

`$_GET['foo'] = 'bar';`


# `post` Element
**parent element: `<php>`**

This element can be used to set a value in the super-global array `$_POST`.
```
<php>
  <post name="foo" value="bar"/>
</php>
```
The XML configuration above corresponds to the following PHP code:

`$_POST['foo'] = 'bar';`


# `cokkie` Element
**Parent element: `<php>`**

This element can be used to set a value in the super-global array $_COOKIE.
```
<php>
  <cookie name="foo" value="bar"/>
</php>
```
The XML configuration above corresponds to the following PHP code:

`$_COOKIE['foo'] = 'bar';`


# `server` Element
**Parent element: `<php>`**

This element can be used to set a value in the super-global array $_SERVER.
```
<php>
  <server name="foo" value="bar"/>
</php>
```
The XML configuration above corresponds to the following PHP code:

`$_SERVER['foo'] = 'bar';`

# `files` Element
**Parent element: `<php>`**

This element can be used to set a value in the super-global array $_FILES.
```
<php>
  <files name="foo" value="bar"/>
</php>
```
The XML configuration above corresponds to the following PHP code:

`$_FILES['foo'] = 'bar';`


# `request` Element
**Parent element: `<php>`**

This element can be used to set a value in the super-global array $_REQUEST.
```
<php>
  <request name="foo" value="bar"/>
</php>
```
The XML configuration above corresponds to the following PHP code:

`$_REQUEST['foo'] = 'bar';`