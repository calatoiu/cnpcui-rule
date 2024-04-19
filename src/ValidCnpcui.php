<?php

namespace calatoiu\CnpcuiRule;

use Closure;
use Illuminate\Support\Facades\Lang;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class ValidCnpcui implements ValidationRule
{

    /**
     * The validator instance.
     *
     * @var Validator
     */
    protected $validator;

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): PotentiallyTranslatedString  $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->checkCNPCUI($value))
            $this->error($fail);
    }

    /**
     * Set the validator instance.
     *
     * @param  Validator  $validator
     * @return void
     */
    public function setValidator($validator): void
    {
        $this->validator = $validator;
    }

    
    /**
     * Validate CNPCUI.
     *
     * @param  string  $cnpcui
     * @return bool
     */
    protected function checkCNPCUI($cnpcui): bool
    {
        return $this->isNumeric($cnpcui) && $this->validLength($cnpcui)
        && $this->validDate($cnpcui) && $this->validHash($cnpcui);


    //    return $cnpcuiLength == strlen($cnpcui);
    }




    private function isNumeric($cnpcui): bool
    {
        return $cnpcui === (string) (int) $cnpcui;
    }

    private function validLength($cnpcui): bool
    {
        return mb_strlen($cnpcui) === 13;
    }

    private function validDate($cnpcui): bool
    {
        $month = (int) "{$cnpcui[3]}{$cnpcui[4]}";
        $day = (int) "{$cnpcui[5]}{$cnpcui[6]}";
        $year = $this->year($cnpcui);

        return 1900 <= $year && $year <= 2050 && checkdate($month, $day, $year);
    }

    private function validHash($cnpcui): bool
    {
        return (int) $cnpcui[12] === $this->hash($cnpcui);
    }

    private function year($cnpcui): int
    {
        $year = ((int) $cnpcui[1] * 10) + ((int) $cnpcui[2]);

        if (in_array((int) $cnpcui[0], [1, 2])) {
            return $year + 1900;
        }

        if (in_array((int) $cnpcui[0], [3, 4])) {
            return $year + 1800;
        }

        return in_array((int) $cnpcui[0], [5, 6])
            ? $year + 2000
            : $this->y2K($year);
    }

    private function y2k($year): int
    {
        $year += 2000;

        return $year > ((int) date('Y') - 14) ? $year - 100 : $year;
    }

    private const HashTable = [2, 7, 9, 1, 4, 6, 3, 5, 8, 2, 7, 9];
    
    private function hash($cnpcui): int
    {
        $hash = array_reduce(
            array_keys(self::HashTable),
            fn ($hash, $key) => $hash += (int) $cnpcui[$key] * self::HashTable[$key]
        ) % 11;

        return $hash === 10 ? 1 : $hash;
    }


    /**
     * Get the validation error message.
     *
     * @param  Closure  $fail
     */
    protected function error(Closure $fail)
    {
        $this->validator && $this->validator->errors();

        return $fail(
            (!class_exists('Lang') || !Lang::has('validation.cnpcui')) ?
                'The :attribute is not a valid CNPCUI.'
                : Lang::get('validation.cnpcui')
        );
    }
}