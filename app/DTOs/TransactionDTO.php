<?php

namespace App\DTOs;

use App\Enums\TransactionClearedEnum;
use App\Enums\TransactionFlagColorEnum;
use Illuminate\Validation\Rules\Enum;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class TransactionDTO extends ValidatedDTO
{
    /**
     * Defines the validation rules for the DTO.
     */
    protected function rules(): array
    {
        return [
            'account_id'          => ['required', 'uuid'],
            'account_name'        => ['required', 'string'],
            'amount'              => ['required', 'numeric'],
            'approved'            => ['required', 'boolean'],
            'cleared'             => ['required', new Enum(TransactionClearedEnum::class)],
            'date'                => ['required', 'date_format:Y-m-d'],
            'id'                  => ['required', 'string'],
            'category_name'       => ['string'],
            'category_id'         => [], // uuid
            'flag_color'          => ['nullable', new Enum(TransactionFlagColorEnum::class)],
            'memo'                => [], // memo
            'payee_id'            => ['nullable','uuid'],
            'payee_name'          => ['nullable','string'],
            'split_parent'        => ['nullable','uuid'],
            'subtransactions'     => ['array'],
            'transfer_account_id' => [], // uuid
        ];
    }

    /**
     * Defines the default values for the properties of the DTO.
     */
    protected function defaults(): array
    {
        return [];
    }

    /**
     * Defines the type casting for the properties of the DTO.
     */
    protected function casts(): array
    {
        return [];
    }

    /**
     * Maps the DTO properties before the DTO instantiation.
     */
    protected function mapBeforeValidation(): array
    {
        return [];
    }

    /**
     * Maps the DTO properties before the DTO export.
     */
    protected function mapBeforeExport(): array
    {
        return [];
    }

    /**
     * Defines the custom messages for validator errors.
     */
    public function messages(): array
    {
        return [];
    }

    /**
     * Defines the custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [];
    }
}
