# Security and compatibility

Report suspected vulnerabilities privately through repository GitHub Security reporting when available, otherwise
contact maintainers privately before disclosure. Never include production secrets in reports or fixtures.

Owner values validate spelling, never credentials/trust. The host authenticates and authorizes the supplied owner and
lifecycle removal. Core exceptions are explicit host policy and must not come from untrusted declarations.

Identifier/policy/capacity/data limits are enforced; no object/resource/executable value enters snapshots. Custom
definition methods are consumer code, which must export bounded data without side effects; validation cannot sandbox
them. Non-finite numbers are refused. Payload strings are preserved without claiming UTF-8 or canonical JSON
validation.

Use SemVer and exact verified pre-1.0 pins. The initial migration is a documented clean break, without
aliases/remaps/fallbacks. Correct released defects through a new version/advisory, never by rewriting tags/artifacts.
