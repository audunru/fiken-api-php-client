<?php

namespace audunru\FikenClient\Tests\Unit;

use audunru\FikenClient\Models\CreditNote;
use audunru\FikenClient\Tests\TestCase;

class CreditNoteTest extends TestCase
{
    public function test_it_creates_a_credit_note()
    {
        $creditNote = new CreditNote();

        $this->assertInstanceOf(
            CreditNote::class,
            $creditNote
        );
    }
}
