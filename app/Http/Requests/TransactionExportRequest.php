<?php

namespace App\Http\Requests;

use App\Enums\BudgetArrangableColumnEnum;
use App\Enums\BudgetFilterableColumnsEnum;
use App\Enums\BudgetSortableColumnsEnum;
use App\Enums\TransactionFlagColorEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class TransactionExportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'start_date' => 'required|date|before:tomorrow',
            'end_date'   => 'date|after_or_equal:start_date',
            'columns'    => [new Enum(BudgetArrangableColumnEnum::class)],
            'include'    => [new Enum(BudgetFilterableColumnsEnum::class)],
            'exclude'    => [new Enum(BudgetFilterableColumnsEnum::class)],
            'sort_by'    => [new Enum(BudgetSortableColumnsEnum::class)],

            //'flag_color' => [new Enum(TransactionFlagColorEnum::class)],
            'include.*.flag_color' => [new Enum(TransactionFlagColorEnum::class)],
            'exclude.*.flag_color' => [new Enum(TransactionFlagColorEnum::class)],

        ];
    }
}
