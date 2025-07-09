<?php
namespace App\Service;

use DateTimeImmutable;

// Service maison pour gérer les JWT (génération, validation, etc.)
class JWTService
{
    /**
     * Génération du JWT
     *
     * @param array $header   Contient les métadonnées du token (ex: typ, alg)
     * @param array $payload  Données utiles du token (ex: userId, roles...)
     * @param string $secret  Clé secrète utilisée pour signer le token
     * @param int $validity   Durée de validité en secondes (défaut : 3h)
     * @return string         Token JWT généré
     */
    public function generate(array $header, array $payload, string $secret, int $validity = 10800): string
    {
        // Si une validité est définie, on ajoute iat (émission) et exp (expiration)
        if($validity > 0){
            $now = new DateTimeImmutable();
            $exp = $now->getTimestamp() + $validity;

            $payload['iat'] = $now->getTimestamp(); // Issued At
            $payload['exp'] = $exp; // Expiration Time
        }

        // On encode le header et le payload en JSON puis en base64
        $base64Header = base64_encode(json_encode($header));
        $base64Payload = base64_encode(json_encode($payload));

        // Nettoyage : on rend le base64 "URL-safe" (conforme au format JWT)
        $base64Header = str_replace(['+', '/', '='], ['-', '_', ''], $base64Header);
        $base64Payload = str_replace(['+', '/', '='], ['-', '_', ''], $base64Payload);

        // Génération de la signature avec HMAC-SHA256
        $secret = base64_encode($secret); // Encodage du secret
        $signature = hash_hmac('sha256', $base64Header . '.' . $base64Payload, $secret, true);

        // Encodage de la signature + nettoyage
        $base64Signature = base64_encode($signature);
        $signature = str_replace(['+', '/', '='], ['-', '_', ''], $base64Signature);

        // Assemblage du token JWT : header.payload.signature
        $jwt = $base64Header . '.' . $base64Payload . '.' . $signature;

        return $jwt;
    }

    /**
     * Vérifie si le token est valide sur la forme
     * (structure correcte : 3 blocs séparés par des points)
     */
    public function isValid(string $token): bool
    {
        return preg_match(
                '/^[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+$/',
                $token
            ) === 1;
    }

    /**
     * Récupère le payload du token (partie avec les données)
     */
    public function getPayload(string $token): array
    {
        // Découpe le token en 3 parties
        $array = explode('.', $token);

        // Décode la 2e partie (payload)
        $payload = json_decode(base64_decode($array[1]), true);

        return $payload;
    }

    /**
     * Récupère le header du token (partie avec les infos d'encodage)
     */
    public function getHeader(string $token): array
    {
        // Découpe le token
        $array = explode('.', $token);

        // Décode la 1ère partie (header)
        $header = json_decode(base64_decode($array[0]), true);

        return $header;
    }

    /**
     * Vérifie si le token est expiré
     */
    public function isExpired(string $token): bool
    {
        $payload = $this->getPayload($token);

        $now = new DateTimeImmutable();

        // Expiré si la date d'expiration est passée
        return $payload['exp'] < $now->getTimestamp();
    }

    /**
     * Vérifie l’intégrité du token : la signature correspond-elle ?
     */
    public function check(string $token, string $secret)
    {
        // Récupération des parties utiles
        $header = $this->getHeader($token);
        $payload = $this->getPayload($token);

        // Regénère un token à partir des mêmes infos (sans changer exp)
        $verifToken = $this->generate($header, $payload, $secret, 0);

        // Compare le token original avec le regénéré
        return $token === $verifToken;
    }
}
