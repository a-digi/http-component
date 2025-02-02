<?php

declare(strict_types=1);

namespace AriAva\Http;

use AriAva\Http\Response\ResponseStatusEnum;

enum HttpCode: int
{
    case OK = 200;
    case Created = 201;
    case Accepted = 202;
    case NonAuthoritativeInformation = 203;
    case NoContent = 204;
    case ResetContent = 205;
    case PartialContent = 206;
    case BadRequest = 400;
    case Unauthorized = 401;
    case Forbidden = 403;
    case NotFound = 404;
    case MethodNotAllowed = 405;
    case NotAcceptable = 406;
    case PreconditionFailed = 407;
    case UnprocessableEntity = 408;
    case InternalServerError = 500;

    public function getStatus(HttpCode $httpCode): ResponseStatusEnum
    {
        return match ($httpCode) {
            HttpCode::OK,
            HttpCode::Created,
            HttpCode::NonAuthoritativeInformation,
            HttpCode::NoContent,
            HttpCode::ResetContent,
            HttpCode::PartialContent,
            HttpCode::Accepted => ResponseStatusEnum::SUCCESS,
            default => ResponseStatusEnum::ERROR,
        };
    }

    public function getCode(): HttpCode
    {
        return match ($this) {
            HttpCode::OK => HttpCode::OK,
            HttpCode::Created => HttpCode::Created,
            HttpCode::NonAuthoritativeInformation => HttpCode::NonAuthoritativeInformation,
            HttpCode::NoContent => HttpCode::NoContent,
            HttpCode::ResetContent => HttpCode::ResetContent,
            HttpCode::PartialContent => HttpCode::PartialContent,
            HttpCode::Accepted => HttpCode::Accepted,
            HttpCode::BadRequest => HttpCode::BadRequest,
            HttpCode::Unauthorized => HttpCode::Unauthorized,
            HttpCode::Forbidden => HttpCode::Forbidden,
            HttpCode::NotFound => HttpCode::NotFound,
            HttpCode::MethodNotAllowed => HttpCode::MethodNotAllowed,
            HttpCode::NotAcceptable => HttpCode::NotAcceptable,
            HttpCode::PreconditionFailed => HttpCode::PreconditionFailed ,
            HttpCode::UnprocessableEntity => HttpCode::UnprocessableEntity,
            default => HttpCode::InternalServerError,
        };
    }

    public static function getCodeFrom(int $code): HttpCode
    {
        return match ($code) {
            200 => HttpCode::OK,
            201 => HttpCode::Created,
            204 => HttpCode::NoContent,
            205 => HttpCode::ResetContent,
            206 => HttpCode::PartialContent,
            202 => HttpCode::Accepted,
            400 => HttpCode::BadRequest,
            401 => HttpCode::Unauthorized,
            403 => HttpCode::Forbidden,
            404 => HttpCode::NotFound,
            405 => HttpCode::MethodNotAllowed,
            406 => HttpCode::NotAcceptable,
            407 => HttpCode::PreconditionFailed ,
            408 => HttpCode::UnprocessableEntity,
            0 => HttpCode::InternalServerError,
            default => HttpCode::InternalServerError,
        };
    }
}
