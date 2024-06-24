<?php

class GermanMathSolver
{
    private function isValidAssignment($digits)
    {
        // Check if all digits are unique (0-9)
        if (count(array_unique($digits)) !== 10) {
            return false;
        }

        // Extract digits for each letter
        $h = $digits['H'];
        $i = $digits['I'];
        $e = $digits['E'];
        $r = $digits['R'];
        $g = $digits['G'];
        $b = $digits['B'];
        $t = $digits['T'];
        $s = $digits['S'];
        $n = $digits['N'];
        $u = $digits['U'];

        // Check if the formula holds
        return ($h + $i + $e + $r) === ($n + $e + $u + $s);
    }

    public function solve()
    {
        // Loop through all possible combinations (0000000000 to 9999999999)
        for ($i = 0; $i <= 9999999999; $i++) {
            // Convert integer to padded string (leading zeros)
            $assignment = str_pad($i, 10, '0', STR_PAD_LEFT);

            // Convert string to array of digits
            $digits = str_split($assignment, 1);
            $digits = array_combine(str_split('HIERGBTSNU'), $digits);

            // Check if valid assignment and return solution if found
            if ($this->isValidAssignment($digits)) {
                return $digits;
            }
        }

        // No solution found

    }
}

// Usage
$solver = new GermanMathSolver;
$solution = $solver->solve();

if ($solution) {
    echo "Solution:\n";
    foreach ($solution as $letter => $digit) {
        echo "$letter -> $digit\n";
    }
} else {
    echo 'No solution found';
}
