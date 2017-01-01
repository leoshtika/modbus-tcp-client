<?php


namespace ModbusTcpClient\Packet\ModbusFunction;


use ModbusTcpClient\Packet\IModbusPacket;
use ModbusTcpClient\Packet\ProtocolDataUnitRequest;
use ModbusTcpClient\Utils\Types;

/**
 * Request for Read Coil Status (FC=01)
 */
class ReadCoilsRequest extends ProtocolDataUnitRequest
{
    /**
     * @var int total number of coils requested. Size 2 bytes
     */
    private $quantity;

    public function __construct($startAddress, $quantity, $unitId = 0, $transactionId = null)
    {
        parent::__construct($startAddress, $unitId, $transactionId);
        $this->quantity = $quantity;

        $this->validate();
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getFunctionCode()
    {
        return IModbusPacket::READ_COILS;
    }

    public function getLength()
    {
        return parent::getLength() + 2; // quantity size (2 bytes)
    }

    public function __toString()
    {
        return parent::__toString()
            . Types::toUInt16BE($this->getQuantity());
    }

    public function validate()
    {
        parent::validate();
        if ((null !== $this->quantity) && ($this->quantity > Types::MIN_VALUE_UINT16 && $this->quantity <= Types::MAX_VALUE_UINT16)) {
            return;
        }
        throw new \OutOfRangeException("quantity is not set or out of range (uint16): {$this->quantity}");
    }

    public static function parse($binaryString)
    {
        // TODO: Implement parse() method.
    }
}