# coverage element
parent element: `<phpunit>`

the `<coverage>` element and its children can be used to configure code coverage:
```
<coverage cacheDirectory="/path/to/directory"
          includeUncoveredFiles="true"
          processUncoveredFiles="true"
          pathCoverage="false"
          ignoreDeprecatedCodeUnits="true"
          disableCodeCoverageIgnore="true">
    <!-- ... -->
</coverage>
```
---
## `cacheDirectory` attribute
---

**possible values: `string`**
when code coverage data is collected and processed, static code analysis is performed to improve reasoning about the covered code. This is an expensive operation, whose result can be cached. When the `cacheDIrectory` attribute is set, static analysis results will be cached in the specified directory.

---
## `includeUncoveredFiles` attribute
---
**possible values: `true` or `false` default: `true`**


when set to `true`, all sourcecode files that are configured to be considered for code coverage analysis will be included in the code coverage report(s). This includes sourcecode files that are not executed while the stats are running.


---
## `processUncoveredFiles` attribute
---
**possible values: `true` or `false` default: `false`**

when set to `true`, all sourcecode files that are configured to be considered for code coverage analysis will be processed. this includes sourcecode files that are not executed while the tests are running.


---
## `ignoreDeprecatedCodeUnits` attribute
---
**possible values: `true` or `false` default: `false`**
this attribute configures whether code units annotated with `@deprecated` should be ignored from code coverage.

---
## `pathCoverage` attribute
---
**possible values: `true` or `false` default: `false`**

when set to `false`, only line coverage data will be collected, processed and reported.
when set to `true`, line coverage, branch coverage and path coverage data will be collectged, processed and reported. this requires a code coverage driver that supports path coverage. path coverage is currenly only implemented by **Xdebug**


---
## `disableCodeCoverageIgnore` attribute
---
**possible values: `true` or `false` default: `false`**
this attribute configures whether the `@codeCoverageIgnore` annotations should be ignored
