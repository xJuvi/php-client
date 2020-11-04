<?php declare(strict_types=1);

namespace Sms77\Api\Validator;

use Sms77\Api\Constant\LookupConstants;
use Sms77\Api\Exception\InvalidOptionalArgumentException;
use Sms77\Api\Exception\InvalidRequiredArgumentException;

class LookupValidator extends BaseValidator implements ValidatorInterface {
    public static function isValidMobileNetworkShortName(string $subject): bool {
        return 1 === preg_match('/d1|d2|o2|eplus|N\/A|int/', $subject);
    }

    /**
     * @throws InvalidOptionalArgumentException
     * @throws InvalidRequiredArgumentException
     */
    public function validate(): void {
        $this->json();
        $this->number();
        $this->type();
    }

    /**
     * @throws InvalidOptionalArgumentException
     */
    public function json(): void {
        $json = $this->fallback('json');

        if (null !== $json) {
            $type = $this->fallback('type');

            if (LookupConstants::TYPE_MNP !== $type) {
                throw new InvalidOptionalArgumentException('json may only be set if type is set to mnp.');
            }

            if (!$this->isValidBool($json)) {
                throw new InvalidOptionalArgumentException('json can be either 1 or 0.');
            }
        }
    }

    /**
     * @throws InvalidRequiredArgumentException
     */
    public function number(): void {
        $number = $this->fallback('number', '');

        if ('' === $number) {
            throw new InvalidRequiredArgumentException('number is missing.');
        }
    }

    /**
     * @throws InvalidRequiredArgumentException
     */
    public function type(): void {
        $type = $this->fallback('type');

        if (!in_array($type, LookupConstants::TYPES, true)) {
            $imploded = implode(',', LookupConstants::TYPES);

            throw new InvalidRequiredArgumentException(
                "type $type is invalid. Valid types are: $imploded.");
        }
    }
}