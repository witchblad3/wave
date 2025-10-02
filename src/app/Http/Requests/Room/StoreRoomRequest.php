<?php

namespace App\Http\Requests\Room;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;

class StoreRoomRequest extends FormRequest
{
    private const NAME = "name";
    private const DESCRIPTION = "description";
    private const IS_PRIVATE = "is_private";
    private const PASSWORD = "password";
    private const PASSWORD_CONFIRMATION = "password_confirmation";
    private const IMAGE = "image";
    private const PARTICIPANTS = 'participants';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            self::NAME => [
                'required',
                'string',
                'max:100'
            ],
            self::DESCRIPTION => [
                'nullable',
                'string',
                'max:1000'
            ],
            self::IS_PRIVATE => [
                'sometimes',
                'boolean'
            ],
            self::PASSWORD => [
                'nullable',
                Rule::requiredIf(fn () => self::IS_PRIVATE == true),
                'string',
                'min:6',
                'confirmed',
            ],
            self::PASSWORD_CONFIRMATION => [
                Rule::requiredIf(fn () => $this->boolean(self::IS_PRIVATE) === true),
                'string',
            ],
            self::IMAGE => [
                'nullable',
                'image',
                'max:2048'
            ],
            self::PARTICIPANTS => [
                'nullable',
                'array',
            ],
            self::PARTICIPANTS . '.*' => [
                'integer',
                'distinct',
                'exists:users,id',
            ],
        ];
    }

    public function getName(): string
    {
        return $this->input(self::NAME);
    }
    public function getDescription(): ?string
    {
        return $this->input(self::DESCRIPTION);
    }
    public function getIsPrivate(): bool
    {
        return $this->boolean(self::IS_PRIVATE);
    }
    public function getPassword(): ?string
    {
        return $this->input(self::PASSWORD);
    }
    public function getImage(): ?UploadedFile
    {
        return $this->file(self::IMAGE);
    }
    public function getPasswordConfirmation(): ?string
    {
        return $this->input(self::PASSWORD_CONFIRMATION);
    }

    public function getParticipantIds(): array
    {
        return $this->input(self::PARTICIPANTS, []);
    }

    public function messages(): array
    {
        return [
            self::PASSWORD.'.required' => 'Для приватной комнаты нужен пароль.',
            self::PASSWORD.'.confirmed' => 'Пароль и подтверждение не совпадают.',
            self::PASSWORD_CONFIRMATION.'.required' => 'Подтвердите пароль для приватной комнаты.',
        ];
    }

}
