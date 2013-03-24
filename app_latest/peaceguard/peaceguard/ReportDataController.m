//
//  ReportDataController.m
//
//  Contributor(s): Ashley Lesperance, Jonas Yao
//
//  Copyright (c) 2013 Number 123 Developer's Group
//


#import "ReportDataController.h"
#import "Report.h"

@interface ReportDataController ()

@end

@implementation ReportDataController

- (void) makeReportWithType:(NSString *)type severity:(NSString *)severity location:(NSString *)location time:(NSInteger *)time andDescription:(NSString *)description{
    self.theReport = [[Report alloc] initWithType:type severity:severity location:location time:time andDescription:description];
    
}

- (void) makeReportWithType: (NSString *) type severity: (NSString *) severity location: (NSString *) location time: (NSInteger *) time image: (NSData *) image andDescription: (NSString *) description{
    self.theReport = [[Report alloc] initWithType:type severity:severity location:location time:time image:image andDescription:description];
    
}

- (NSString  *) getPOSTData: (NSString *) email{
    NSString *postData;
    if (self.theReport.image == Nil){
        postData = [NSString stringWithFormat:@"email=%@&type=%@&severity=%@&location=%@&time=%ld&description=%@&agent=iphone", email, self.theReport.type, self.theReport.severity,self.theReport.location,(long)self.theReport.time,self.theReport.description];
    }
    return postData;
}

@end
