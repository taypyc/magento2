<?php
/**
 * @copyright Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 */

namespace Magento\Bundle\Pricing\Price;

use Magento\TestFramework\Helper\ObjectManager as ObjectManagerHelper;

class BundleSelectionFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Magento\Bundle\Pricing\Price\BundleSelectionFactory */
    protected $bundleSelectionFactory;

    /** @var ObjectManagerHelper */
    protected $objectManagerHelper;

    /** @var \Magento\Framework\ObjectManagerInterface|\PHPUnit_Framework_MockObject_MockObject */
    protected $objectManagerMock;

    /** @var \Magento\Framework\Pricing\Object\SaleableInterface|\PHPUnit_Framework_MockObject_MockObject */
    protected $bundleMock;

    /** @var \Magento\Framework\Pricing\Object\SaleableInterface|\PHPUnit_Framework_MockObject_MockObject */
    protected $selectionMock;

    protected function setUp()
    {
        $this->bundleMock = $this->getMock('Magento\Catalog\Model\Product', [], [], '', false);
        $this->selectionMock = $this->getMock('Magento\Catalog\Model\Product', [], [], '', false);

        $this->objectManagerMock = $this->getMock('Magento\Framework\ObjectManagerInterface');

        $this->objectManagerHelper = new ObjectManagerHelper($this);
        $this->bundleSelectionFactory = $this->objectManagerHelper->getObject(
            'Magento\Bundle\Pricing\Price\BundleSelectionFactory',
            [
                'objectManager' => $this->objectManagerMock
            ]
        );
    }

    public function testCreate()
    {
        $result = $this->getMock('Magento\Bundle\Pricing\Price\BundleSelectionPrice', [], [], '', false);
        $this->objectManagerMock->expects($this->once())
            ->method('create')
            ->with(
                $this->equalTo(BundleSelectionFactory::SELECTION_CLASS_DEFAULT),
                $this->equalTo(
                    [
                        'test' => 'some value',
                        'bundleProduct' => $this->bundleMock,
                        'saleableItem' => $this->selectionMock,
                        'quantity' => 2.,
                    ]
                )
            )
        ->will($this->returnValue($result));
        $this->assertSame(
            $result,
            $this->bundleSelectionFactory
                ->create($this->bundleMock, $this->selectionMock, 2., ['test' => 'some value'])
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCreateException()
    {
        $this->objectManagerMock->expects($this->once())
            ->method('create')
            ->with(
                $this->equalTo(BundleSelectionFactory::SELECTION_CLASS_DEFAULT),
                $this->equalTo(
                    [
                        'test' => 'some value',
                        'bundleProduct' => $this->bundleMock,
                        'saleableItem' => $this->selectionMock,
                        'quantity' => 2.,
                    ]
                )
            )
            ->will($this->returnValue(new \stdClass()));
        $this->bundleSelectionFactory->create($this->bundleMock, $this->selectionMock, 2., ['test' => 'some value']);
    }
}