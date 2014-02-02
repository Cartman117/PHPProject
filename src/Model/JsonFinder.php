<?php

namespace Model;

use Exception\HttpException;

class JsonFinder implements FinderInterface
{
    private $jsonFile;

    public function __construct($file)
    {
        $this->jsonFile = $file;
    }

    /**
     * {@inheritDoc}
     */
    public function findAll()
    {
        $statuses = json_decode(file_get_contents($this->jsonFile), true);
        $arrayStatuses = array();
        foreach ($statuses['statuses'] as $status) {
            array_push($arrayStatuses, $this->generateStatusFromArray($status));
        }

        return $arrayStatuses;
    }

    /**
     * {@inheritDoc}
     */
    public function findOneById($id)
    {
        $statuses = json_decode(file_get_contents($this->jsonFile), true);
        foreach ($statuses['statuses'] as $status) {
            if($id == $status['id']) {
                return $this->generateStatusFromArray($status);
            }
        }

        return null;
    }

    public function findNextStatusId()
    {
        $arrayStatuses = $this->findAll();

        return (end($arrayStatuses) !== false) ? end($arrayStatuses)->getId() + 1 : 0;
    }

    public function addNewStatus(Status $status)
    {
        // Add the status in an array.
        $arrayStatus = $this->createStatusArray($status);

        // Decode the JSON File in an array.
        if ('' === file_get_contents($this->jsonFile)) {
            $arrayStatuses = array();
        }
        else {
            $arrayStatuses = json_decode(file_get_contents($this->jsonFile), true);
        }

        if ($this->verifyStatusNotExisting($arrayStatuses['statuses'], $arrayStatus['id'])) {
            // Creer une exception du type StatusAlreadyExistingException
            throw new HttpException(400, 'ID status already existing.');
        }

        array_push($arrayStatuses['statuses'], $arrayStatus);

        file_put_contents($this->jsonFile, json_encode($arrayStatuses));

    }

    private function createStatusArray(Status $status)
    {
        return array(
                   'content'        => $status->getContent(),
                   'id'             => $status->getId(),
                   'username'       => $status->getUsername(),
                   'date'           => $status->getDate(),
                   'clientUsed'     => $status->getClientUsed(),
               );
    }

    private function verifyStatusNotExisting(array $statuses, $idStatus)
    {
        // Verify if the id status is already contained in the JSON file.
        foreach ($statuses as $object) {
            if ($idStatus === $object['id']) {
                return true;
            }
        }
        return false;
    }

    private function generateStatusFromArray(array $arrayStatus)
    {
        return new Status(
            $arrayStatus['content'],
            $arrayStatus['id'],
            $arrayStatus['username'],
            new \DateTime($arrayStatus['date']),
            $arrayStatus['clientUsed']
        );
    }
}