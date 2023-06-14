<?php
/**
 * both of these terms refer to the growing practice of invoking statements similar to 
 */

$object->foo()->bar()->zebra()->alpha()->selfDestruct();

/**
 * the long chain of method calls isn't necessarily a bad thing, assuming they each link back to a local
 * object the calling class knows. As a fun example, Mockery's long chains (after the first shouldReceive()
 * method) all call to the same instance of \Mockery\Expectation. however, sometimes this is not the case
 * and the chain is constantly crossing object boundaries.
 * 
 * in either case, mocking such a chain can be a horrible task. to make it easier mockery supports demeter chain mocking. 
 * essentially, we shortcut through the chain and return a defined value
 * from the final call, foe example, let's assume selfDestruct() return the string (Ten!) to $object(an instance
 * of CaptainsConsole) here's how we could mock it
 */

$mock = \Mockery::mock('CaptainConsole');
$mock->shouldReceive('foo->bar->zebra->alpha->selfDestruct')->andReturn('Ten!');

/**
 * above expectation can follow any previously seen format or expectation, except that
 * the method name is simple the string of all expected chain calls separated by ->
 * Mockery will automatically setup the chain of expected calls with its final return values,
 * regardless of whatever intermediary object might be used in the real implementation
 * 
 * arguments to all members of the chian (except the final call) are ignored in this process
 */