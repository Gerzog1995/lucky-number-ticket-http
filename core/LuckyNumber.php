<?php

namespace Core;

/**
 * Class LuckyNumber
 * @package Сore
 */
class LuckyNumber
{
    const ITERATION_BORDER = 3;

    /**
     * Getting a lucky ticket number
     * @param array $getData
     * @return mixed
     */
    public function gettingLuckyNumber(array $getData)
    {
        $start = microtime(true);
        $listArray = [];
        if (is_array($getData) && !empty($getData) && array_key_exists('first', $getData) && array_key_exists('end', $getData)) {
            $firstNumber = $getData['first'];
            $EndNumber = $getData['end'];
            if (count($this->getListOfNumber($firstNumber)) <= 6 || count($this->getListOfNumber($EndNumber))  <= 6) {
                if ($firstNumber > $EndNumber && ($firstNumber - $EndNumber) > 100) {
                    for ($numberI = $EndNumber; $numberI <= $firstNumber; $numberI++) {
                        if ($response = $this->getCheckOnIdentity($numberI))
                            $listArray[] = $response;
                    }
                } elseif ($firstNumber < $EndNumber && ($EndNumber - $firstNumber) > 100) {
                    for ($numberI = $firstNumber; $numberI <= $EndNumber; $numberI++) {
                        if ($response = $this->getCheckOnIdentity($numberI))
                            $listArray[] = $response;
                    }
                } else {
                    throw new \Exception('The difference between the range of the first and the end must be at least 100.');
                }
                $time = microtime(true) - $start;
                array_push($listArray, ['time' => 'Затраченное время(млс): ' . $time]);
                return $listArray;
            }
            throw new \Exception('The range of numbers must be from 000001 to 999999!');
        }
        throw new \Exception('Array processing error!');
    }
    
    /**
     * Get the list of numbers.
     * @param integer $number
     * @return array
     */
    private function getListOfNumber(int $number): array
    {
        return str_split(strval($number));
    }

    /**
     * Get count of split
     * @param array $splitNumber
     * @return integer
     */
    private function getCountSplit(array $splitNumber): int
    {
        return count($splitNumber) > self::ITERATION_BORDER ? self::ITERATION_BORDER : count($splitNumber);;
    }

    /**
     * Get the number of the last three numbers. Recurse.
     * @param integer $number
     * @return integer
     */
    private function getIntEndThree(int $number): int
    {
        $splitNumber = $this->getListOfNumber($number);
        $splitNumber = count($splitNumber) < self::ITERATION_BORDER ? $splitNumber : array_slice($splitNumber, count($splitNumber) - self::ITERATION_BORDER, count($splitNumber));
        $countSplit = $this->getCountSplit($splitNumber);
        $iCountOfSlice = count(array_slice($splitNumber, 0, $countSplit));
        $iCountOfSlice = $countSplit == 1 ? 1 : $iCountOfSlice;
        $responseNumber = 0;
        for ($i = 0; $i < $iCountOfSlice; $i++) {
            $responseNumber += $splitNumber[$i];
        }
        return $responseNumber > 9 ? $this->getIntEndThree($responseNumber) : $responseNumber;
    }

    /**
     * Get the number of the first three numbers. Recurse.
     * @param integer $number
     * @return integer
     */
    private function getIntFirstThree(int $number): int
    {
        $splitNumber = $this->getListOfNumber($number);
        $countSplit = $this->getCountSplit($splitNumber);
        $iCountOfSlice = count(array_slice($splitNumber, 0, $countSplit));
        $iCountOfSlice = $countSplit == 1 ? 1 : $iCountOfSlice;
        $responseNumber = 0;
        for ($i = 0; $i < $iCountOfSlice; $i++) {
            $responseNumber += $splitNumber[$i];
        }
        return $responseNumber > 9 ? $this->getIntEndThree($responseNumber) : $responseNumber;
    }

    /**
     * Get an identity check
     * @param integer $number
     * @return mixed
     */
    private function getCheckOnIdentity(int $number)
    {
        if(count($this->getListOfNumber($number)) == 6) {
            return $this->getIntFirstThree($number) == $this->getIntEndThree($number) ? $number : false;
        }
        return false;

    }
    
}
