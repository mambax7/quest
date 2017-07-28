<?php

/**
 *
 * PHP Get Method Command-like Interface
 *
 * Copyright (C) 2006 Matsuda Shota
 * http://sgssweb.com/
 * admin@sgssweb.com
 *
 * ------------------------------------------------------------------------
 *
 * 2006-4-20        First release.
 *
 */

/*

    Syntax:

        Function:
            function_name argment1,argment2,...;

        Constructor:
            {object_name:argment1,argment2,...}

        Variable:
            {variable_name}

        Property of variable:
            {variable_name.property_name}

        String:
            'characters'
            "characters"

        Number:
            integer_number
            floating_number
            0xhexadecimal_number
            0Xhexadecimal_number
            #hexadecimal_number
            0bbinary_number
            0Bbinary_number

        Constant:
            constant_value
*/

class GMIExecution
{
    public $nameTable    = array(); // array
    public $commands     = array(); // array
    public $pluggableSet = null; // GMIPluggableSet
    public $isDebugMode  = false; // boolean

    /**
     * GMIExecution constructor.
     */
    public function __construct()
    {
        error_reporting(0);
    }

    // void setPluggableSet(GMIPluggableSet pluggableSet)

    /**
     * @param $pluggableSet
     */
    public function setPluggableSet($pluggableSet)
    {
        $this->pluggableSet = $pluggableSet;
        $this->prepareVariables($pluggableSet->getVariables());
    }

    // void prepareVariables(array anArray)

    /**
     * @param array $anArray
     */
    public function prepareVariables($anArray = array())
    {
        //reset($anArray);
        //while (list($name, $exp) = each($anArray)) {
        foreach ($anArray as $name => $exp) {
            // split expression into variable name.
            $matches = array();
            preg_match_all('/^\s*([\w]+)\s*$/', $name, $matches);

            // stop if expression is not valid
            if (count($matches[0]) == 0) {
                continue;
            }
            $name = $matches[1][0];

            $this->nameTable[$name] = $this->createValue($exp);
        }
    }

    // GMIValue getVariable(string name)

    /**
     * @param $name
     * @return mixed|null
     */
    public function getVariable($name)
    {
        return isset($this->nameTable[$name]) ? $this->nameTable[$name] : null;
    }

    // void setDebugMode(boolean isDebugMode) {

    /**
     * @param $isDebugMode
     */
    public function setDebugMode($isDebugMode)
    {
        error_reporting(0);
        $this->isDebugMode = $isDebugMode;
    }

    // GMIValue createValue(string exp)

    /**
     * @param $exp
     * @return \GMIConstant|\GMIConstructor|\GMINumber|\GMIString|\GMIVariable
     */
    public function createValue($exp)
    {
        $exp = trim($exp);

        if (preg_match('/^\{\s*\w+(?:\w+\.\w+)?\s*\}$/', $exp)) {
            $value = new GMIVariable($this, $exp);
        } elseif (preg_match('/^\{\s*\w+\:.*\}$/', $exp)) {
            $value = new GMIConstructor($this, $exp);
        } elseif (preg_match('/^(?:(?:[-+]?\d*\.?\d+)|^(?:0[bB](?:[01]+))|^(?:(?:0[xX]|\#)(?:[\da-fA-F]+)))$/', $exp)) {
            $value = new GMINumber($this, $exp);
        } elseif (preg_match('/^[a-zA-Z][\w\-]+$/', $exp)) {
            $value = new GMIConstant($this, $exp);
        } elseif (preg_match('/^(?:\".*\"|\\\'.*\\\')$/', $exp)) {
            if (substr($exp, 0, 1) == "'") {
                $exp = preg_replace('/\\\\\'/', "'", substr($exp, 1, -1));
            } else {
                $exp = preg_replace('/\\\\"/', '"', substr($exp, 1, -1));
            }
            $value = new GMIString($this, preg_replace('/(?<!\\\\)\\\\n/', "\n", $exp));
        } else {
            $value = new GMIString($this, preg_replace('/(?<!\\\\)\\\\n/', "\n", $exp));
        }

        return $value;
    }

    // boolean validateArguments(array types, array args);

    /**
     * @param $types
     * @param $args
     * @return bool
     */
    public function validateArguments($types, &$args)
    {
        if (count($types) != count($args)) {
            return false;
        }

        reset($types);
        //while (list($i) = each($types)) {
        foreach ($types as $i) {
            if ($types[$i] === null) {
                break;
            }

            // constant
            if (is_array($types[$i])) {
                if ($args[$i]->getType() != 'constant') {
                    return false;
                }
                //reset($types[$i]);
                //while (list($n) = each($types[$i])) {
                foreach ($types[$i] as $n) {
                    if ($args[$i]->getValue() == $types[$i][$n]) {
                        break;
                    }
                    if ($n == count($types[$i])) {
                        return false;
                    }
                }
            } // value
            elseif ($types[$i] != $args[$i]->getType()) {
                return false;
            }
        }

        return true;
    }


    // array extractArguments(int startIndex, int endIndex, array args)

    /**
     * @param $startIndex
     * @param $endIndex
     * @param $args
     * @return array
     */
    public function extractArguments($startIndex, $endIndex, &$args)
    {
        $newArgs = array();

        for ($i = $startIndex; $i <= $endIndex; $i++) {
            $newArgs[$i - $startIndex] =& $args[$i];
        }

        return $newArgs;
    }


    // mixed construct(string class, array args)

    /**
     * @param $class
     * @param $args
     * @return null
     */
    public function construct($class, &$args)
    {
        return null;
    }


    // GMIValue getProperty(GMIVariable variable, string property)

    /**
     * @param $variable
     * @param $property
     * @return null
     */
    public function getProperty(&$variable, $property)
    {
        return null;
    }

    // void command(string name, array args)

    /**
     * @param $name
     * @param $args
     */
    public function command($name, &$args)
    {
        switch ($name) {
            case 'debug':
                $this->setDebugMode(true);
                break;
        }
    }

    // void execute(string exp)

    /**
     * @param string $exp
     */
    public function execute($exp = '')
    {
        if ($this->pluggableSet !== null) {
            $exp = $this->pluggableSet->getExpression();
        }

        // add slash before ";" in such quoted value as "...", '...' or {...}.
        $lines = preg_replace_callback('/(?<!\\\)\\\'(?:\\\\\'|[^\'])*(?:(?<!\\\)\\\')|' . '(?<!\\\)\"(?:\\\\"|[^"])*(?:(?<!\\\)\")|' . '(?<=\{)(?:[^{}]*(?:\{[^{}]*\})*[^{}]*)*(?=\})/', create_function('$matches', 'return preg_replace(\'/([;])/\', "\\\\\\\$1", $matches[0]);'), $exp);

        // split expression into an array by unexcaped ";".
        $lines = preg_split('/\s*(?<!\\\)\;\s*/', $lines);

        $index = 0;
        //reset($lines);
        //while (list($i) = each($lines)) {
        foreach ($lines as $i) {
            // skip empty line.
            if ($lines[$i] == '') {
                continue;
            }
            // remove slashes inserted above.
            $lines[$i] = preg_replace_callback('/(?<!\\\)\\\'(?:\\\\\'|[^\'])*(?:(?<!\\\)\\\')|' . '(?<!\\\)\"(?:\\\\"|[^"])*(?:(?<!\\\)\")|' . '(?<=\{)(?:[^{}]*(?:\{[^{}]*\})*[^{}]*)*(?=\})/', create_function('$matches', 'return preg_replace(\'/\\\\\([;])/\', "$1", $matches[0]);'), $lines[$i]);

            // convert and store.
            $this->commands[$index] = new GMICommand($this, trim($lines[$i]));
            $this->commands[$index]->execute();

            $index++;
        }
    }

    // void debug()
    public function debug()
    {
        echo '<html><body style="margin:0;padding:0;font-size:small;">';
        echo '<br />&nbsp;&nbsp;<strong>Variables</strong><br />';
        echo '<table style="border-collapse:collapse;border:solid 1px #dedede;font-size:small;">';
        echo '<tr style="background:#cccccc;border: solid 1px #aaaaaa;">';
        echo '<td style="color:white;border-right: solid 1px #aaaaaa;padding:0 10px;white-space:nowrap;">Name</td>';
        echo '<td style="color:white;border-right: solid 1px #aaaaaa;padding:0 10px;white-space:nowrap;text-align:center;">Type</td>';
        echo '<td style="color:white;border-right: solid 1px #aaaaaa;padding:0 10px;white-space:nowrap;">Value (Structured)</td>';
        echo '<td style="color:white;border-right: solid 1px #aaaaaa;padding:0 10px;white-space:nowrap;">Expression</td>';
        echo '</tr>';
        reset($this->nameTable);
        $i = 0;
        //while (list($name) = each($this->nameTable)) {
        foreach ($this->nameTable as $name) {
            echo '<tr>';
            echo '<td style="background:' . ($i % 2 == 0 ? '#edf3fe' : '#ffffff') . ';border-right: solid 1px ' . ($i % 2 == 0 ? '#ced4dd' : '#dedede') . ";padding:2px 10px;white-space:nowrap;vertical-align:top;\"><strong>$name</strong></td>";
            echo '<td style="background:' . ($i % 2 == 0 ? '#e6ebf6' : '#f7f7f7') . ';border-right: solid 1px ' . ($i % 2 == 0 ? '#ced4dd' : '#dedede') . ';padding:2px 10px;white-space:nowrap;text-align:center;vertical-align:top;">' . $this->nameTable[$name]->getType() . '</td>';
            echo '<td style="background:' . ($i % 2 == 0 ? '#edf3fe' : '#ffffff') . ';border-right: solid 1px ' . ($i % 2 == 0 ? '#ced4dd' : '#dedede') . ';padding:2px 10px;color:gray;">';
            ob_start();
            var_dump($this->nameTable[$name]->getValue());
            echo preg_replace('/\s\s/m', '&nbsp;&nbsp;&nbsp;&nbsp;', nl2br(ob_get_clean()));
            echo '</td>';
            echo '<td style="background:' . ($i % 2 == 0 ? '#e6ebf6' : '#f7f7f7') . ';border-right: solid 1px ' . ($i % 2 == 0 ? '#ced4dd' : '#dedede') . ';padding:2px 10px;">' . $this->nameTable[$name]->expression . '</td>';
            echo '</tr>';
            $i++;
        }
        echo '</table>';
        echo '<br />&nbsp;&nbsp;<strong>Commands</strong><br />';
        echo '<table style="border-collapse:collapse;border:solid 1px #dedede;font-size:small;">';
        reset($this->commands);
        //    while (list($i) = each($this->commands)) {
        foreach ($this->commands as $i) {
            echo '<tr style="border-bottom:solid 1px #9cbaeb;">';
            echo '<td colspan="2" style="background:#3875d7;color:white;padding:2px 5px;"><strong>&or; ' . $this->commands[$i]->name . '</strong></td>';
            echo '<td colspan="2" style="text-align:right;background:#3875d7;color:#9cbaeb;padding:2px 5px;">' . $this->commands[$i]->expression . '</span></td>';
            echo '</tr>';
            echo '<tr style="background:#cccccc;border: solid 1px #aaaaaa;">';
            echo '<td style="color:white;border-right: solid 1px #aaaaaa;padding:0 10px;white-space:nowrap;">Argument</td>';
            echo '<td style="color:white;border-right: solid 1px #aaaaaa;padding:0 10px;white-space:nowrap;text-align:center;">Type</td>';
            echo '<td style="color:white;border-right: solid 1px #aaaaaa;padding:0 10px;white-space:nowrap;">Value (Structured)</td>';
            echo '<td style="color:white;border-right: solid 1px #aaaaaa;padding:0 10px;white-space:nowrap;">Expression</td>';
            echo '</tr>';
            reset($this->commands[$i]->arguments);
            //while (list($n) = each($this->commands[$i]->arguments)) {
            foreach($this->commands[$i]->arguments as $n) {
                    echo '<tr>';
                    echo '<td style="background:' . ($n % 2 == 0 ? '#edf3fe' : '#ffffff') . ';border-right: solid 1px ' . ($n % 2 == 0 ? '#ced4dd' : '#dedede') . ";padding:2px 10px;white-space:nowrap;vertical-align:top\">Argument $n</td>";
                    echo '<td style="background:' . ($n % 2 == 0 ? '#e6ebf6' : '#f7f7f7') . ';border-right: solid 1px ' . ($n % 2 == 0 ? '#ced4dd' : '#dedede') . ';padding:2px 10px;white-space:nowrap;text-align:center;vertical-align:top">' . $this->commands[$i]->arguments[$n]->getType() . '</td>';
                    echo '<td style="background:' . ($n % 2 == 0 ? '#edf3fe' : '#ffffff') . ';border-right: solid 1px ' . ($n % 2 == 0 ? '#ced4dd' : '#dedede') . ';padding:2px 10px;vertical-align:top;color:gray;">';
                    ob_start();
                    var_dump($this->commands[$i]->arguments[$n]->getValue());
                    echo preg_replace('/\s\s/m', '&nbsp;&nbsp;&nbsp;&nbsp;', nl2br(ob_get_clean()));
                    echo '</td>';
                    echo '<td style="background:' . ($n % 2 == 0 ? '#e6ebf6' : '#f7f7f7') . ';border-right: solid 1px ' . ($n % 2 == 0 ? '#ced4dd' : '#dedede') . ';padding:2px 10px;vertical-align:top;">' . $this->commands[$i]->arguments[$n]->expression . '</td>';
                    echo '</tr>';
                }
                echo '</tr>';
            }
            echo '</table>';
            echo '</body></html>';
        }
}
    /**
     * Class GMIDefaultPluggableSet
     */
class GMIDefaultPluggableSet extends GMIPluggableSet
{
    public $defaultVariables; // array
    public $expression; // string

    // GMIDefaultPluggableSet(string expression, array defaultVariables)
    /**
     * GMIDefaultPluggableSet constructor.
     * @param $expression
     * @param $defaultVariables
     */
    public function __construct($expression, $defaultVariables)
    {
        parent::__construct();
        $this->expression       = $expression;
        $this->defaultVariables = $defaultVariables;
    }
    // string getExpression()

    /**
     * @return mixed
     */
    public function getExpression()
    {
        return $this->expression;
    }
    // array getVariables()

    /**
     * @return mixed
     */
    public function getVariables()
    {
        return $this->defaultVariables;
    }
}

/**
 * Class GMIPluggableSet
 */
class GMIPluggableSet
{
    // GMIPluggableSet()
    /**
     * GMIPluggableSet constructor.
     */
    public function __construct()
    {
    }
    // string getExpression()

    /**
     * @return string
     */
    public function getExpression()
    {
        return '';
    }
    // array getVariables()

    /**
     * @return array
     */
    public function getVariables()
    {
        return array();
    }
}

/**
 * Class GMIElement
 */
class GMIElement
{
    public $execution  = null; // GMIExecution
    public $expression = null; // string

    // GMIElement(GMIExecution execution)
    /**
     * GMIElement constructor.
     * @param $execution
     * @param $expression
     */
    public function __construct(&$execution, $expression)
    {
        $this->execution  =& $execution;
        $this->expression = $expression;
    }
}

/**
 * Class GMICommand
 */
class GMICommand extends GMIElement
{
    public $name      = ''; // string
    public $arguments = array(); // array

    // GMICommand(GMIExecution execution, string expression)
    /**
     * GMICommand constructor.
     * @param $execution
     * @param $expression
     */
    public function __construct(&$execution, $expression)
    {
        parent::__construct($execution, $expression);

        // split expression into command name and arguments expression.
        $matches = array();
        preg_match_all('/^(\w+)(?:\s+(.*)$|$)/', $expression, $matches);

        // stop if expression is not valid
        if (count($matches[0]) == 0) {
            return;
        }

        $this->name = $matches[1][0];

        // stop if argument is empty
        if ($matches[2][0] == '') {
            return;
        }

        // add slash before "," in such quoted value as "...", '...' or {...}.
        $matches[2][0] = preg_replace_callback('/(?<!\\\)\\\'(?:\\\\\'|[^\'])*(?:(?<!\\\)\\\')|' . '(?<!\\\)\"(?:\\\\"|[^"])*(?:(?<!\\\)\")|' . '(?<=\{)(?:[^{}]*(?:\{[^{}]*\})*[^{}]*)*(?=\})/', create_function('$matches', 'return preg_replace(\'/([,])/\', "\\\\\\\$1", $matches[0]);'),
                                               $matches[2][0]);

        // split arguments expression into an array by unexcaped ",".
        $this->arguments = preg_split('/\s*(?<!\\\)\,\s*/', $matches[2][0]);

        reset($this->arguments);
        //        while (list($i) = each($this->arguments)) {
        foreach ($this->arguments as $i) {
            // remove slashes inserted above.
            $this->arguments[$i] = preg_replace_callback('/(?<!\\\)\\\'(?:\\\\\'|[^\'])*(?:(?<!\\\)\\\')|' . '(?<!\\\)\"(?:\\\\"|[^"])*(?:(?<!\\\)\")|' . '(?<=\{)(?:[^{}]*(?:\{[^{}]*\})*[^{}]*)*(?=\})/', create_function('$matches', 'return preg_replace(\'/\\\\\([,])/\', "$1", $matches[0]);'),
                                                         $this->arguments[$i]);
            // convert and store.
            $this->arguments[$i] = $this->execution->createValue($this->arguments[$i]);
        }
    }

    // void execute()
    public function execute()
    {
        $this->execution->command($this->name, $this->arguments);
    }
}

/**
 * Class GMIValue
 */
class GMIValue extends GMIElement
{
    public $value = null; // mixed

    // GMIValue(GMIExecution execution, string expression)
    /**
     * GMIValue constructor.
     * @param $execution
     * @param $expression
     */
    public function __construct(&$execution, $expression)
    {
        parent::__construct($execution, $expression);
    }
    // mixed getValue()

    /**
     * @return null
     */
    public function getValue()
    {
        return $this->expression;
    }
    // string getType()

    /**
     * @return null
     */
    public function getType()
    {
        return null;
    }
}

/**
 * Class GMIConstructor
 */
class GMIConstructor extends GMIValue
{
    public $class; // string
    public $arguments; // array

    // GMIConstructor(GMIExecution execution, string expression)
    /**
     * GMIConstructor constructor.
     * @param $execution
     * @param $expression
     */
    public function __construct(&$execution, $expression)
    {
        parent::__construct($execution, $expression);

        // split expression into class name and arguments expression.
        $matches = array();
        preg_match_all('/^\{\s*(\w+)\s*\:(?:\s*(.*)|\s*)\}$/', $expression, $matches);

        // stop if expression is not valid
        if (count($matches[0]) == 0) {
            return;
        }

        $this->class = $matches[1][0];

        // add slash before "," in such quoted value as "..." or '...'.
        $matches[2][0] = preg_replace_callback('/(?<!\\\)\\\'(?:\\\\\'|[^\'])*(?:(?<!\\\)\\\')|' . '(?<!\\\)\"(?:\\\\"|[^"])*(?:(?<!\\\)\")/', create_function('$matches', 'return preg_replace(\'/([,])/\', "\\\\\\\$1", $matches[0]);'), $matches[2][0]);

        // split arguments expression into an array by unexcaped ",".
        $this->arguments = preg_split('/\s*(?<!\\\)\,\s*/', $matches[2][0]);

        reset($this->arguments);
        //        while (list($n) = each($this->arguments)) {
        foreach ($this->arguments as $n) {
            // remove slashes inserted above.
            $this->arguments[$n] = preg_replace_callback('/(?<!\\\)\\\'(?:\\\\\'|[^\'])*(?:(?<!\\\)\\\')|' . '(?<!\\\)\"(?:\\\\"|[^"])*(?:(?<!\\\)\")/', create_function('$matches', 'return preg_replace(\'/\\\\\([,])/\', "$1", $matches[0]);'), $this->arguments[$n]);
            // convert and store.
            $this->arguments[$n] = $this->execution->createValue($this->arguments[$n]);
        }
    }
    // mixed getValue()

    /**
     * @return null
     */
    public function getValue()
    {
        if ($this->value === null) {
            $this->value = $this->execution->construct($this->class, $this->arguments);
        }

        return $this->value;
    }
    // string getType()

    /**
     * @return string
     */
    public function getType()
    {
        if ($this->value === null) {
            $this->value = $this->execution->construct($this->class, $this->arguments);
        }

        return ($this->value !== null) ? $this->class : 'null';
    }
}

/**
 * Class GMIVariable
 */
class GMIVariable extends GMIValue
{
    public $variableName;
    public $propertyName;

    // GMIVariable(GMIExecution execution, string expression)

    /**
     * GMIVariable constructor.
     * @param $execution
     * @param $expression
     */
    public function __construct(&$execution, $expression)
    {
        parent::__construct($execution, $expression);

        // split expression into variable name.
        $matches = array();
        preg_match_all('/^\{\s*((\w+)(?:\.(\w+))?)\s*\}$/', $expression, $matches);

        // stop if expression is not valid
        if (count($matches[0]) == 0) {
            return;
        }

        $this->variableName = $matches[2][0];
        $this->propertyName = ($matches[3][0] != '') ? $matches[3][0] : null;
    }
    // mixed getValue()

    /**
     * @return null
     */
    public function getValue()
    {
        if ($this->value === null) {
            $this->value =& $this->execution->getVariable($this->variableName);

            // acquire property of the variable
            if ($this->value !== null && $this->propertyName !== null) {
                $value =& $this->value;
                unset($this->value);
                $this->value = $this->execution->getProperty($value, $this->propertyName);
            }
        }

        return ($this->value !== null) ? $this->value->getValue() : null;
    }
    // string getType()

    /**
     * @return string
     */
    public function getType()
    {
        if ($this->value === null) {
            $this->value =& $this->execution->getVariable($this->variableName);

            // acquire property of the variable
            if ($this->value !== null && $this->propertyName !== null) {
                $value =& $this->value;
                unset($this->value);
                $this->value = $this->execution->getProperty($value, $this->propertyName);
            }
        }

        return ($this->value !== null) ? $this->value->getType() : 'null';
    }
}

/**
 * Class GMIConstant
 */
class GMIConstant extends GMIValue
{
    // GMIConstant(GMIExecution execution, string expression)
    /**
     * GMIConstant constructor.
     * @param $execution
     * @param $expression
     */
    public function __construct(&$execution, $expression)
    {
        parent::__construct($execution, $expression);
    }
    // string getType()

    /**
     * @return string
     */
    public function getType()
    {
        return 'constant';
    }
}

/**
 * Class GMINumber
 */
class GMINumber extends GMIValue
{
    // GMINumber(GMIExecution execution, string expression)
    /**
     * GMINumber constructor.
     * @param $execution
     * @param $expression
     */
    public function __construct(&$execution, $expression)
    {
        parent::__construct($execution, $expression);
    }
    // mixed getValue()

    /**
     * @return null|number|string
     */
    public function getValue()
    {
        if ($this->value === null) {
            $this->value = $this->decode($this->expression);
        }

        return $this->value + 0;
    }
    // string getType()

    /**
     * @return string
     */
    public function getType()
    {
        return 'number';
    }
    // int decode(string n)

    /**
     * @param $n
     * @return number|string
     */
    public function decode($n)
    {
        if (preg_match('/^0[xX](?:[0-7][\da-fA-F]{7}|[\da-fA-F]{1,7})$/', $n)) {
            $n = hexdec(substr(trim($n), 2));
        } elseif (preg_match('/^\#(?:[0-7][\da-fA-F]{7}|[\da-fA-F]{1,7})$/', $n)) {
            $n = hexdec(substr(trim($n), 1));
        } elseif (preg_match('/^0[Bb][01]{1,31}$/', $n)) {
            $n = bindec(substr(trim($n), 2));
        } else {
            $n = trim($n);
        }

        return $n;
    }
}

/**
 * Class GMIString
 */
class GMIString extends GMIValue
{
    // GMIString(GMIExecution execution, string expression)
    /**
     * GMIString constructor.
     * @param $execution
     * @param $expression
     */
    public function __construct(&$execution, $expression)
    {
        parent::__construct($execution, $expression);
    }
    // string getType()

    /**
     * @return string
     */
    public function getType()
    {
        return 'string';
    }
}
