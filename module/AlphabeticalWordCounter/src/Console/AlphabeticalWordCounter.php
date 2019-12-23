<?php

namespace AlphabeticalWordCounter\Console;

use GuzzleHttp\ClientInterface;

class AlphabeticalWordCounter extends AbstractCommand
{
    private $client;
    private $file;

    protected $name = 'alphabetical-word-counter';

    public function __construct(ClientInterface $client, string $file)
    {
        $this->client = $client;
        $this->file   = $file;
    }

    public function execute(): int {
        echo 'Fetching latest version of the dictionary file. This may take a while ¯\_(ツ)_/¯' . PHP_EOL;

        $startTime   = time(true);
        $response    = $this->client->request('GET', $this->file);
        $requestTime = microtime(true) - $startTime;

        if (200 !== $response->getStatusCode()) {
            echo 'Unable to get dictionary file' . PHP_EOL;
            return 1;
        }

        echo 'Obtained file from server, proceeding to parse.' . PHP_EOL;
        echo 'Request took ' . bcdiv($requestTime, 1000000, 3) . 's' . PHP_EOL;

        $matches = [];
        $body    = $response->getBody();
        $words   = explode("\n", $body);

        array_map('trim', $words);
        array_map('strtolower', $words);

        foreach ($words as $word) {
            $sorted = $this->sortString($word);

            if (trim($word) === trim($sorted)) {
                $matches[] = $word;
            }
        }

        echo sprintf(
            'Out of %d words, %d are the same when sorted alphabetically %s',
            count($words),
            count($matches),
            PHP_EOL
        );

        echo sprintf(
            'This equates to %s%% of all of the words in this dictionary %s',
            bcmul(bcdiv(count($matches), count($words), 20), 100, 3),
            PHP_EOL
        );

        echo 'This took ' . bcdiv((microtime(true) - $requestTime - $startTime), 1000000, 3) . ' to reach this conclusion' . PHP_EOL;

        return 0;
    }

    private function sortString(string $input): string
    {
        $chunked = str_split($input);
        sort($chunked);
        return implode($chunked);
    }
}
