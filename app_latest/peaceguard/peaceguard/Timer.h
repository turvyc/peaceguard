//
//  Timer.h
//
//  Contributor(s): Jonas Yao
//
//  Copyright (c) 2013 Number 13 Developer's Group
//

#import <Foundation/Foundation.h>

@interface Timer : NSObject {
    NSDate *start;
    NSDate *end;
}

- (void) startTimer;
- (void) stopTimer;
- (double) timeElapsedInSeconds;
- (double) timeElapsedInMilliseconds;
- (double) timeElapsedInMinutes;

@end
