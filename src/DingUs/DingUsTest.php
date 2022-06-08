<?php

namespace test;
// require_once  __DIR__.'/../../../vendor/autoload.php';
// use experienceengine\serenitylib\DingUsNOtify;

use experienceengine\serenityxml\DingUsNotify;
use ReflectionClass;
use ReflectionMethod;

/**
 * @testFunction testDingUsNotifyTest
 */
class DingUsNotifyTest extends \PHPUnit\Framework\TestCase
{

    private $conventBookingPullRQ = 
        '<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"
        xmlns:SOAPENC="http://schemas.xmlsoap.org/soap/encoding/"
        xmlns:xsi="http://www.w3.org/2001/XMLSchemainstance"
        xmlns:xsd="http://www.w3.org/2001/XMLSchema">
        <SOAP-ENV:Body>
            <m:OTA_HotelResNotifRQ xmlns:m="http://www.opentravel.org/OTA/2003/05" TimeStamp="2017-07-12T09:34:12" Version="1">
                <m:POS>
                    <m:Source>
                        <m:RequestorID MessagePassword="rM4374xG" ID="rmi-expeng"/>
                    </m:Source>
                </m:POS>
                <m:HotelReservations>
                    <m:HotelReservation ResStatus="Book" CreatorID="" CreateDateTime="2016-09-27T09:21:00">
                        <m:TimeSpan Start="2017-12-01" End="2017-12-06"/> <!-- start = arrival date, end = departure date-->
                        <m:RoomStays>
                            <m:RoomStay RoomID="1143820006"> <!-- XML ROOMID-->
                                <m:Comments>
                                    <m:Comment>
                                        <m:Text>non-smoking room</m:Text> <!-- Request -->
                                    </m:Comment>
                                </m:Comments>
                                <m:RoomRates>
                                    <m:RoomRate MealPlanCode="AI" />
                                    <m:Rates>
                                        <m:Rate UnitMultiplier="7" RateTimeUnit="Day" EffectiveDate="2022-11-14" ExpireDate="2022-11-21">
                                            <m:Base AmountAfterTax="310.20" CurrencyCode="USD"/>
                                        </m:Rate>
                                    </m:Rates>
                                </m:RoomRates>
                                <m:GuestCounts>
                                    <m:GuestCount AgeQualifyingCode="10" Count="2" Age="30"/>
                                </m:GuestCounts>
                                <m:TimeSpan Start="2022-11-14" End="2022-11-21"/>
                                <m:Total AmountAfterTax="2171.40" CurrencyCode="USD"/>
                                <m:ResGuestRPHs RPH="1"/>
                            </m:RoomStay>
                            <m:RoomStay RoomID="1143830006">
                                <m:RoomRates>
                                    <m:RoomRate MealPlanCode="AI" />
                                    <m:Rates>
                                        <m:Rate UnitMultiplier="7" RateTimeUnit="Day" EffectiveDate="2022-11-14" ExpireDate="2022-11-21">
                                            <m:Base AmountAfterTax="442.86" CurrencyCode="USD"/>
                                        </m:Rate>
                                    </m:Rates>
                                </m:RoomRates>
                                <m:GuestCounts>
                                    <m:GuestCount AgeQualifyingCode="10" Count="2" Age="30"/>
                                    <m:GuestCount AgeQualifyingCode="8" Count="1" Age="12"/>
                                </m:GuestCounts>
                                <m:TimeSpan Start="2022-11-14" End="2022-11-21"/>
                                <m:Total AmountAfterTax="3100.02" CurrencyCode="USD"/>
                                <m:ResGuestRPHs RPH="2"/>
                            </m:RoomStay>
                        </m:RoomStays>
                        <m:ResGuests>
                            <m:ResGuest PrimaryIndicator="true" ResGuestRPH="1" AgeQualifyingCode="10">
                                <m:Profiles>
                                    <m:ProfileInfo>
                                        <m:Profile ProfileType="1">
                                            <m:Customer>
                                                <m:PersonName>
                                                    <m:NamePrefix>Mr</m:NamePrefix>
                                                    <m:GivenName>TestLeadGuestF </m:GivenName>
                                                    <m:Surname>TestLeadGuestL</m:Surname>
                                                </m:PersonName>
                                            </m:Customer>
                                        </m:Profile>
                                    </m:ProfileInfo>
                                </m:Profiles>
                            </m:ResGuest>
                            <m:ResGuest PrimaryIndicator="false" ResGuestRPH="1" AgeQualifyingCode="10">
                                <m:Profiles>
                                    <m:ProfileInfo>
                                        <m:Profile ProfileType="1">
                                            <m:Customer>
                                                <m:PersonName>
                                                    <m:NamePrefix>Mrs</m:NamePrefix>
                                                    <m:GivenName>FRGAF</m:GivenName>
                                                    <m:Surname>FRGAL</m:Surname>
                                                </m:PersonName>
                                            </m:Customer>
                                        </m:Profile>
                                    </m:ProfileInfo>
                                </m:Profiles>
                            </m:ResGuest>
                            <m:ResGuest PrimaryIndicator="false" ResGuestRPH="2" AgeQualifyingCode="10">
                                <m:Profiles>
                                    <m:ProfileInfo>
                                        <m:Profile ProfileType="1">
                                            <m:Customer>
                                                <m:PersonName>
                                                    <m:NamePrefix>Mrs</m:NamePrefix>
                                                    <m:GivenName>SRGAF</m:GivenName>
                                                    <m:Surname>SRGAL</m:Surname>
                                                </m:PersonName>
                                            </m:Customer>
                                        </m:Profile>
                                    </m:ProfileInfo>
                                </m:Profiles>
                            </m:ResGuest>
                            <m:ResGuest PrimaryIndicator="false" ResGuestRPH="2" AgeQualifyingCode="10">
                                <m:Profiles>
                                    <m:ProfileInfo>
                                        <m:Profile ProfileType="1">
                                            <m:Customer>
                                                <m:PersonName>
                                                    <m:NamePrefix>Mrs</m:NamePrefix>
                                                    <m:GivenName>SRGBF</m:GivenName>
                                                    <m:Surname>SRGBL</m:Surname>
                                                </m:PersonName>
                                            </m:Customer>
                                        </m:Profile>
                                    </m:ProfileInfo>
                                </m:Profiles>
                            </m:ResGuest>
                            <m:ResGuest PrimaryIndicator="false" ResGuestRPH="2" AgeQualifyingCode="8">
                                <m:Profiles>
                                    <m:ProfileInfo>
                                        <m:Profile ProfileType="1">
                                            <m:Customer>
                                                <m:PersonName>
                                                    <m:NamePrefix>Mrs</m:NamePrefix>
                                                    <m:GivenName>SRChildAF</m:GivenName>
                                                    <m:Surname>SRChildAL</m:Surname>
                                                </m:PersonName>
                                            </m:Customer>
                                        </m:Profile>
                                    </m:ProfileInfo>
                                </m:Profiles>
                            </m:ResGuest>
                        </m:ResGuests>
                        <m:ResGlobalInfo>
                            <m:Total AmountAfterTax="5271.42" CurrencyCode="USD"/>
                            <m:BasicPropertyInfo HotelCode="208" HotelName="The Fives Oceanfront"/>
                            <m:HotelReservationIDs>
                                <m:HotelReservationID ResID_Type="14" ResID_Value="2294518"/><!-- XML Book Reference-->
                            </m:HotelReservationIDs>
                        </m:ResGlobalInfo>
                    </m:HotelReservation>
                </m:HotelReservations>
            </m:OTA_HotelResNotifRQ>
        </SOAP-ENV:Body>
    </SOAP-ENV:Envelope>';

    private  $bookingRS = '  
    <BookingResponse xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
        <RequestInfo>
            <Timestamp>1653922242</Timestamp>
            <TimestampISO>2022-05-30T14:50:42+00:00</TimestampISO>
            <Host>xml.centriumres.com.localdomain.ee</Host>
            <HostIP>10.0.0.168</HostIP>
            <ReqID>6294d9c29cef87.47119582</ReqID>
        </RequestInfo>
        <ReturnStatus>
            <Success>True</Success>
            <Exception/>
        </ReturnStatus>
        <BookingDetails>
            <BookingReference>2294518</BookingReference>
            <Status>Live</Status>
            <ArrivalDate>2022-11-14</ArrivalDate>
            <Duration>7</Duration>
            <LeadGuest>
                <FirstName>TestLeadGuestF</FirstName>
                <LastName>TestLeadGuestL</LastName>
                <Title>Mr</Title>
            </LeadGuest>
            <Request>non-smoking room</Request>
            <TradeReference>asdf</TradeReference>
            <TotalPrice>5271.42</TotalPrice>
            <Currency>USD</Currency>
            <DueDate>2022-11-09</DueDate>
            <RoomBookings>
                <RoomBooking>
                    <RoomID>1143820006</RoomID>
                    <Name>Jr. Suite Unspecified View</Name>
                    <MealBasisID>1</MealBasisID>
                    <Adults>2</Adults>
                    <Children>0</Children>
                    <Infants>0</Infants>
                    <Guests>
                        <Guest>
                            <Type>Adult</Type>
                            <FirstName>FRGAF</FirstName>
                            <LastName>FRGAL</LastName>
                            <Title>Mrs</Title>
                        </Guest>
                    </Guests>
                    <Supplements/>
                    <SpecialOffers>
                        <SpecialOffer>
                            <Name>5 for 4 Free Nights Offer</Name>
                            <Type>Discount Percentage</Type>
                            <PaxType>All</PaxType>
                            <Total>470</Total>
                        </SpecialOffer>
                        <SpecialOffer>
                            <Name>MAY22 - Save up to 31%</Name>
                            <Type>Free Nights</Type>
                            <Total>648.6</Total>
                        </SpecialOffer>
                        <SpecialOffer>
                            <Name>$555 Resort Credit</Name>
                            <Type>Value Added</Type>
                            <Desc>Promotion entitles guest to receive one (1) physical $555 Resort &#xD; Credit coupon sheet per room with multiple detachable resort credit coupons which may be used on enhancements to their experience while staying at our resorts</Desc>
                            <Total>-0</Total>
                        </SpecialOffer>
                    </SpecialOffers>
                    <Taxes>
                        <Tax>
                            <TaxName>IAH</TaxName>
                            <Inclusive>True</Inclusive>
                            <Total>63.24</Total>
                        </Tax>
                        <Tax>
                            <TaxName>IVA</TaxName>
                            <Inclusive>True</Inclusive>
                            <Total>299.5</Total>
                        </Tax>
                    </Taxes>
                    <RoomPrice>2171.4</RoomPrice>
                </RoomBooking>
                <RoomBooking>
                    <RoomID>1143830006</RoomID>
                    <Name>1 Bedroom Residence Partial Ocean View</Name>
                    <MealBasisID>1</MealBasisID>
                    <Adults>2</Adults>
                    <Children>1</Children>
                    <Infants>0</Infants>
                    <Guests>
                        <Guest>
                            <Type>Adult</Type>
                            <FirstName>SRGAF</FirstName>
                            <LastName>SRGAL</LastName>
                            <Title>Mrs</Title>
                        </Guest>
                        <Guest>
                            <Type>Adult</Type>
                            <FirstName>SRGBF</FirstName>
                            <LastName>SRGBL</LastName>
                            <Title>Mrs</Title>
                        </Guest>
                        <Guest>
                            <Type>Child</Type>
                            <FirstName>SRChildAF</FirstName>
                            <LastName>SRChildAL</LastName>
                            <Title>Mrs</Title>
                            <Age>12</Age>
                        </Guest>
                    </Guests>
                    <Supplements/>
                    <SpecialOffers>
                        <SpecialOffer>
                            <Name>5 for 4 Free Nights Offer</Name>
                            <Type>Discount Percentage</Type>
                            <PaxType>All</PaxType>
                            <Total>671</Total>
                        </SpecialOffer>
                        <SpecialOffer>
                            <Name>MAY22 - Save up to 31%</Name>
                            <Type>Free Nights</Type>
                            <Total>925.98</Total>
                        </SpecialOffer>
                        <SpecialOffer>
                            <Name>$555 Resort Credit</Name>
                            <Type>Value Added</Type>
                            <Desc>Promotion entitles guest to receive one (1) physical $555 Resort &#xD; Credit coupon sheet per room with multiple detachable resort credit coupons which may be used on enhancements to their experience while staying at our resorts</Desc>
                            <Total>-0</Total>
                        </SpecialOffer>
                    </SpecialOffers>
                    <Taxes>
                        <Tax>
                            <TaxName>IAH</TaxName>
                            <Inclusive>True</Inclusive>
                            <Total>90.29</Total>
                        </Tax>
                        <Tax>
                            <TaxName>IVA</TaxName>
                            <Inclusive>True</Inclusive>
                            <Total>427.59</Total>
                        </Tax>
                    </Taxes>
                    <RoomPrice>3100.02</RoomPrice>
                </RoomBooking>
            </RoomBookings>
            <Property>
                <PropertyID>208</PropertyID>
                <PropertyName>The Fives Oceanfront</PropertyName>
                <Rating>5</Rating>
                <Errata/>
                <GeographyLevel1ID>38</GeographyLevel1ID>
                <GeographyLevel2ID>6</GeographyLevel2ID>
                <GeographyLevel3ID>6</GeographyLevel3ID>
                <Country>Mexico</Country>
                <Area>Cancun</Area>
                <Region>Cancun</Region>
                <Strapline>Relax and recharge your senses at this luxury hotel in Puerto Morelos, Mexico.</Strapline>
                <CMSBaseURL>https://www.rmidirect.co.uk/custom/content/</CMSBaseURL>
                <MainImage>CMSImage_664.jpg</MainImage>
                <MainImageThumbnail>CMSImageThumb_664.jpg</MainImageThumbnail>
                <Images>
                    <Image>
                        <FullSize>CMSImage_665.jpg</FullSize>
                        <Thumbnail>CMSImageThumb_665.jpg</Thumbnail>
                    </Image>
                    <Image>
                        <FullSize>CMSImage_666.jpg</FullSize>
                        <Thumbnail>CMSImageThumb_666.jpg</Thumbnail>
                    </Image>
                    <Image>
                        <FullSize>CMSImage_667.jpg</FullSize>
                        <Thumbnail>CMSImageThumb_667.jpg</Thumbnail>
                    </Image>
                    <Image>
                        <FullSize>CMSImage_668.jpg</FullSize>
                        <Thumbnail>CMSImageThumb_668.jpg</Thumbnail>
                    </Image>
                    <Image>
                        <FullSize>CMSImage_669.jpg</FullSize>
                        <Thumbnail>CMSImageThumb_669.jpg</Thumbnail>
                    </Image>
                </Images>
            </Property>
        </BookingDetails>
    </BookingResponse>';

    // public function testBookingNotify()
    // {
    //     $result = DingUsNOtify::bookingNotify('2294518', '1203');


    // }

    public function testGetBookingData()
    {
        $reflctor = new ReflectionClass('experienceengine\serenityxml\DingUsNotify');
        $method = $reflctor->getMethod('getBookingData');
        $method->setAccessible(true);
        $result = $method->invokeArgs(new DingUsNOtify(), ["2294518", "1203"]);

        // $method = new \ReflectionMethod('\experienceengine\serenitylib\DingUsNOtify', 'getBookingData');
        // $method->setAccessible(true);
        // $result = $method->invokeArgs(new DingUsNOtify(),["2294518","1203"]);


        $target = \simplexml_load_string($this->bookingRS)->BookingDetails;

        $this->assertEquals($result, $target);
    }

    public function testGeneratebookingNotifyReq()
    {

        $bookingData = \simplexml_load_string($this->bookingRS);
        $method = new ReflectionMethod('experienceengine\serenityxml\DingUsNotify', 'generatebookingNotifyReq');
        $method->setAccessible(true);
        $result = $method->invokeArgs(new DingUsNotify(), [$bookingData]);


        $this->assertEquals($this->conventBookingPullRQ, $result);
    }
}

