# Trimmer for Craft

A smart trimming / truncating plugin for Craft.

##Params
1. **Length:** The _character_ count you want to display
2. **Word:** If you want the plugin to backtrack to the nearest full word, defaults to true.
3. **Ellipsis:** Appended to the end of the string, defaults to: "..."

## Usage

####As a Filter
`{{ entry.body | trimit(100) }}`

####As a Function
`{{ trimit(entry.body, 100) }}`

## Examples
#### No Ellipsis
`{{ entry.body | trimit(100, true, "") }}`

#### Truncate by char's
`{{ entry.body | trimit(100, false, "") }}`

`{{ entry.body | trimit(100, "no", "") }}`

`{{ entry.body | trimit(100, "false", "") }}`

#### Multiple variables or a combination of strings
    {% filter trimit(100) %}
        {{ someVar }} {{ someOtherVar }}
    {% endfilter %}

##Notes
* HTML Tags are always removed.
* If the length of your string is less than the length defined then the plugin will return the full string with out html tags & no ellipsis.