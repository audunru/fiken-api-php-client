<?php

namespace audunru\FikenClient\Tests\Unit;

use audunru\FikenClient\Models\CreditNote;
use audunru\FikenClient\Tests\TestCase;

class CreditNoteTest extends TestCase
{
    public function testItCreatesACreditNote()
    {
        $creditNote = new CreditNote();

        $this->assertInstanceOf(
            CreditNote::class,
            $creditNote
        );
    }
}
