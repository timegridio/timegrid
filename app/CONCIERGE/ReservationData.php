<?php

namespace Concierge;

class ReservationData
{
    protected $issuer;

    protected $business;

    protected $service;

    protected $contact;

    protected $date;

    protected $time;

    protected $comments;

    public function issuer($user)
    {
        $this->issuer = $user;

        return $this;
    }

    public function business($slug)
    {
        $this->business = $slug;

        return $this;
    }

    public function forBusiness($slug)
    {
        return $this->business($slug);
    }

    public function service($slug)
    {
        $this->service = $slug;

        return $this;
    }

    public function forService($slug)
    {
        return $this->service($slug);
    }

    public function contact($identifier)
    {
        $this->contact = $identifier;

        return $this;
    }

    public function forContact($identifier)
    {
        return $this->contact($identifier);
    }

    public function date($date)
    {
        $this->date = $date;

        return $this;
    }

    public function onDate($date)
    {
        return $this->date($date);
    }

    public function time($time)
    {
        $this->time = $time;

        return $this;
    }

    public function atTime($time)
    {
        return $this->time($time);
    }

    public function comments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    public function withComments($comments)
    {
        return $this->comments($comments);
    }
}
