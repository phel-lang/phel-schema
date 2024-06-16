<?php

declare(strict_types=1);

namespace Smeghead\PhelSchema;

final class ZodError extends \RuntimeException {
  public array $issues = [];

  public static function create(string $message, array $issues): self
  {
    $self = new self($message);
    $self->issues = $issues;
    return $self;
  }

  public function getIssues(): array
  {
    return $this->issues;
  }
}
