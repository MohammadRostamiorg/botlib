<?php

namespace app;


class StateManager
{
    public $states = [];
    public $basedir;

    public function __construct()
    {
        $basedir = dirname(__DIR__ . "../");
        $this->basedir = $basedir;
        $statesFilePath = $basedir . "/data/state.json";
        $states = file_get_contents($statesFilePath);
        $this->states = json_decode($states, true);
    }

    public function checkUserStated($id)
    {
        foreach ($this->states as $state) {
            if ($state['id'] == $id) {
                return true;
            }
        }
        return false;
    }

    public function setState($id, $state)
    {
        if (empty($this->states) || is_null($state)) {
            $this->states = [];
        }

        $user = [
            'id' => $id,
            'state' => $state
        ];
        foreach ($this->states as $key => $state) {
            if ($state['id'] == $id) {
                $this->states[$key] = $user;
                $this->states = json_encode($this->states);
                file_put_contents($this->basedir . "/data/state.json", $this->states);
                return;
            }
        }
        array_push($this->states, $user);
        $this->states = json_encode($this->states);
        file_put_contents($this->basedir . "/data/state.json", $this->states);

    }

    public function getState($id)
    {
        foreach ($this->states as $key => $state) {
            if ($state['id'] == $id) {
                return $this->states[$key];
            }
        }
        return "user not stated";
    }
}


